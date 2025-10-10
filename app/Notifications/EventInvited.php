<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Notification;
use App\Models\Event;
use Illuminate\Notifications\Messages\BroadcastMessage;

class EventInvited extends Notification implements ShouldBroadcast
{
    use Queueable;
    public $event;

    /**
     * Create a new notification instance.
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

     /**
     * Get the broadcastable representation of the notification.
     */
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'event_id' => $this->event->id,
            'title' => 'Hai un nuovo evento in calendario!',
            'message' => $this->event->title,
            'start' => $this->event->start,
            'end' => $this->event->end,
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'event_id' => $this->event->id,
            'title' => 'Hai un nuovo evento in calendario!',
            'message' => $this->event->title,
            'start' => $this->event->start,
            'end' => $this->event->end,
        ];
    }
} 