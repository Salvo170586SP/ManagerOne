<?php

namespace App\Livewire;

use App\Models\Message;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class Headernav extends Component
{
    public $notifications;
    public $unreadCount;
    public $unreadMessagesCount;

    public function mount()
    {
        $this->refreshNotifications();
        $this->unreadMessagesCount = Auth::user()->unreadMessagesCount();
    }

    #[On('notification-deleted')]
    #[On('all-notifications-deleted')]
    #[On('new-message-sent')]
    #[On('refresh-headernav')]
    public function refreshNotifications()
    {
        $user = Auth::user();
        $this->notifications = $user->notifications;
        $this->unreadCount = $user->unreadNotifications->count();
        $this->unreadMessagesCount = $user->unreadMessagesCount();
    }



    public function markAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        $this->unreadCount = 0;
    }

    public function destroy($notificationId)
    {
        $notification = Auth::user()->notifications()->findOrFail($notificationId);
        $notification->delete();
        $this->dispatch('notification-deleted');
        $this->refreshNotifications();
    }

    public function destroyAll()
    {
        Auth::user()->notifications()->delete();
        $this->dispatch('all-notifications-deleted');
        $this->refreshNotifications();
    }

    public function render()
    {
        return view('livewire.headernav');
    }
}
