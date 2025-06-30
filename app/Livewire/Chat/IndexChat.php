<?php

namespace App\Livewire\Chat;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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

    public function render()
    {
        return view('livewire.chat.index-chat');
    }
}
