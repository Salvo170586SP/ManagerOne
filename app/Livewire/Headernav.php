<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;

class Headernav extends Component
{
    public $notifications;
    public $unreadCount;
    public $unreadMessages;
    public $userId;

    public function mount()
    {
        $this->userId = Auth::id();
        $this->refreshNotifications();
        $this->unreadMessages = Auth::user()->unreadMessagesCount();
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
        $this->unreadMessages = $user->unreadMessagesCount();
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

    // Metodo per ricevere gli eventi Echo tramite JavaScript
    public function getListeners()
    {
        return [
            "echo-private:App.Models.User.{$this->userId},Illuminate\\Notifications\\Events\\BroadcastNotificationCreated" => 'handleNotification',
        ];
    }

    public function render()
    {
        return view('livewire.headernav');
    }
}
