<?php

namespace App\Livewire\Chat;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;

class IndexChat extends Component
{
    public $selectedUser = null;
    public $messageContent = '';
    public $users = [];
    public $messages = [];
    public $search = '';
    public $unreadCounts = [];
    public bool $showDrawer2 = false;



    public function mount()
    {
        $this->loadUsers();
        $this->loadUnreadCounts();
    }

    public function loadUsers()
    {
        $currentUser = Auth::user();

        // Se è super admin, mostra tutti gli utenti tranne i clienti e se stesso
        if ($currentUser->hasRole('super_admin')) {
            $this->users = User::whereDoesntHave('roles', function ($query) {
                $query->where('name', 'client');
            })
                ->where('id', '!=', $currentUser->id)
                ->orderBy('name')
                ->get();
        } elseif ($currentUser->hasRole('project_manager')) {
            // Recupera tutti i team dove è PM (usando la relazione teams come Collection)
            $pmTeams = $currentUser->teams->filter(function($team) use ($currentUser) {
                return $team->users->contains(function($user) use ($currentUser) {
                    return $user->id === $currentUser->id && $user->type === 'project_manager';
                });
            });

            // Recupera tutti i collaboratori (developers) dei team
            $collaboratorIds = collect();
            foreach ($pmTeams as $team) {
                $collaboratorIds = $collaboratorIds->merge($team->developers()->pluck('users.id'));
            }
            $collaboratorIds = $collaboratorIds->unique()->filter(fn($id) => $id != $currentUser->id);

            // Recupera anche il super admin
            $superAdminIds = User::role('super_admin')->pluck('id');

            $userIds = $collaboratorIds->merge($superAdminIds)->unique();

            $this->users = User::whereIn('id', $userIds)
                ->orderBy('name')
                ->get();
        } elseif ($currentUser->hasRole('developer')) {
            // Recupera tutti i team dove è developer
            $devTeams = $currentUser->teams;

            $collaboratorIds = collect();
            $pmIds = collect();
            foreach ($devTeams as $team) {
                // Altri developers del team
                $collaboratorIds = $collaboratorIds->merge($team->developers()->pluck('users.id'));
                // PM del team
                $pmIds = $pmIds->merge($team->pms()->pluck('users.id'));
            }
            $collaboratorIds = $collaboratorIds->unique()->filter(fn($id) => $id != $currentUser->id);
            $pmIds = $pmIds->unique();

            // Recupera anche il super admin
            $superAdminIds = User::role('super_admin')->pluck('id');

            $userIds = $collaboratorIds->merge($pmIds)->merge($superAdminIds)->unique();

            $this->users = User::whereIn('id', $userIds)
                ->orderBy('name')
                ->get();
        } else {
            // Per altri ruoli, mostra solo super admin e developer
            $this->users = User::whereHas('roles', function ($query) {
                $query->whereIn('name', ['super_admin', 'developer']);
            })
                ->where('id', '!=', $currentUser->id)
                ->orderBy('name')
                ->get();
        }
    }

    public function loadUnreadCounts()
    {
        $currentUser = Auth::user();
        $this->unreadCounts = [];

        foreach ($this->users as $user) {
            $this->unreadCounts[$user->id] = Message::where('sender_id', $user->id)
                ->where('receiver_id', $currentUser->id)
                ->where('is_read', false)
                ->count();
        }
    }

    public function selectUser($userId)
    {
        $this->selectedUser = User::find($userId);
        $this->loadMessages();
        $this->markMessagesAsRead();
    }

    public function loadMessages()
    {
        if (!$this->selectedUser) {
            $this->messages = [];
            return;
        }

        $currentUser = Auth::user();
        $this->messages = Message::betweenUsers($currentUser->id, $this->selectedUser->id)
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function sendMessage()
    {
        if (empty(trim($this->messageContent)) || !$this->selectedUser) {
            return;
        }

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $this->selectedUser->id,
            'content' => trim($this->messageContent),
        ]);

        $this->messageContent = '';
        $this->loadMessages();

        // Dispatch the MessageSent event for real-time broadcasting
        MessageSent::dispatch($message);

        // Dispatch a Livewire event to notify other chat instances
        $this->dispatch('new-message-sent', [
            'sender_id' => Auth::id(),
            'receiver_id' => $this->selectedUser->id,
            'message_id' => $message->id
        ]);
    }

    public function markMessagesAsRead()
    {
        if (!$this->selectedUser) {
            return;
        }

        $currentUser = Auth::user();
        Message::where('sender_id', $this->selectedUser->id)
            ->where('receiver_id', $currentUser->id)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        $this->loadUnreadCounts();
        $this->dispatch('refresh-headernav');
    }

    #[On('new-message-sent')]
    public function handleNewMessage($data = null)
    {
        $currentUser = Auth::user();

        if (!$data) {
            return;
        }

        $senderId = is_array($data) ? $data['sender_id'] : $data->sender_id;
        $selectedUserId = is_object($this->selectedUser) ? $this->selectedUser->id : (is_array($this->selectedUser) ? $this->selectedUser['id'] : null);

        // Se la chat attiva è proprio con chi ha inviato il messaggio, aggiorno i messaggi e segno come letti
        if ($this->selectedUser && $selectedUserId === $senderId) {
            $this->loadMessages();
            $this->markMessagesAsRead();
        }
        // In ogni caso aggiorno i conteggi degli unread
        $this->loadUnreadCounts();
    }

    public function getFilteredUsersProperty()
    {
        if (empty($this->search)) {
            return $this->users;
        }

        return $this->users->filter(function ($user) {
            return str_contains(strtolower($user->name . ' ' . $user->surname), strtolower($this->search));
        });
    }

    public function clearChat()
    {
        if (!$this->selectedUser) {
            return;
        }

        Message::betweenUsers(Auth::id(), $this->selectedUser->id)->delete();

        $this->loadMessages();

        // Potresti voler mostrare una notifica di successo
        $this->dispatch('chat-cleared', 'La chat è stata svuotata.');
    }



    public function openDetailsSidebar()
    {
        $this->showDrawer2 = true;
    }

    public function closeDetailsSidebar()
    {
        $this->showDrawer2 = false;
    }

    public function render()
    {
        return view('livewire.chat.index-chat');
    }
}
