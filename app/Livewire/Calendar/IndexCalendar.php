<?php

namespace App\Livewire\Calendar;

use App\Models\Event;
use App\Models\User;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Attributes\On;

class IndexCalendar extends Component
{
    public array $events = [];
    public array $tasks = [];
    public bool $showCreateModal = false;
    public string $componentId;

    public string $title = '';
    public string $description = '';
    public string $start_date = '';
    public string $end_date = '';
    public bool $is_available = false;
    public $selectedParticipants = [];
    public $eventId = null;

    public function mount()
    {
        $this->componentId = 'calendar-' . uniqid();
        $this->loadEvents();
    }

    public function loadEvents()
    {
        $user = Auth::user();

        $this->events = Event::with(['participants', 'creator'])
            ->where('user_id', $user->id)
            ->orWhereHas('participants', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->get()
            ->map(function ($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'description' => $event->description,
                    'start' => $event->start,
                    'end' => $event->end,
                    'participants' => $event->participants->map(fn($user) => $user->name)->toArray(),
                    'creator' => optional($event->creator)->name,
                    'user_id' => $event->user_id,
                    'is_available' => $event->is_available
                ];
            })->toArray();

        $this->tasks = Task::all()->toArray();
    }

    #[On('calendar-select')]
    public function showCreateModal($dateInfo)
    {
        $this->resetForm();
        $this->start_date = $dateInfo['startStr'];
        $this->end_date = $dateInfo['endStr'];
        $this->showCreateModal = true;
    }

    public function saveEvent()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable|string',
            'selectedParticipants' => 'nullable'
        ]);

        if ($this->eventId) {
            $event = Event::findOrFail($this->eventId);
            if ($event->user_id !== Auth::id()) {
                return;
            }
            $event->title = $this->title;
            $event->description = $this->description;
            $event->start = $this->start_date;
            $event->end = $this->end_date;
            $event->is_available = $this->is_available;
            $event->save();
            $participants = User::find(Arr::wrap($this->selectedParticipants));
            $event->participants()->sync($participants->pluck('id'));
            $this->showCreateModal = false;
            $this->dispatch('event-updated', eventData: [
                'id' => $event->id,
                'title' => $event->title,
                'description' => $event->description,
                'start' => $event->start,
                'end' => $event->end,
                'participants' => $participants->pluck('name')->toArray(),
                'is_available' => $this->is_available,
                'creator' => Auth::user()->name,
                'user_id' => Auth::id(),
            ]);

            Log::info('Evento in calendario modificato', [
                'id' => $event->id,
                'title' => $event->title,
                'description' => $event->description,
                'start' => $event->start,
                'end' => $event->end,
                'is_available' => $event->is_available,
            ]);
        } else {
            $event = Event::create([
                'user_id' => Auth::id(),
                'title' => $this->title,
                'description' => $this->description,
                'start' => $this->start_date,
                'end' => $this->end_date,
                'is_available' => $this->is_available,
            ]);
            $participants = User::find(Arr::wrap($this->selectedParticipants));
            $event->participants()->sync($participants->pluck('id'));
            $this->showCreateModal = false;
            $this->dispatch('event-created', eventData: [
                'id' => $event->id,
                'title' => $event->title,
                'description' => $event->description,
                'start' => $event->start,
                'end' => $event->end,
                'participants' => $participants->pluck('name')->toArray(),
                'is_available' => $this->is_available,
                'creator' => Auth::user()->name,
                'user_id' => Auth::id(),
            ]);
            Log::info('Evento in calendario creato', [
                'id' => $event->id,
                'title' => $event->title,
                'description' => $event->description,
                'start' => $event->start,
                'end' => $event->end,
                'is_available' => $event->is_available,
            ]);
        }


        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset(['title', 'description', 'start_date', 'end_date', 'selectedParticipants', 'is_available', 'eventId']);
    }

    public function getPotentialParticipantsProperty()
    {
        return User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'client');
        })->where('id', '!=', Auth::id())->get();
    }

    #[On('update-event')]
    public function updateEvent($eventId, $newStart, $newEnd = null)
    {
        $event = Event::find($eventId);
        if ($event && $event->user_id === Auth::id()) {
            $event->start = $newStart;
            $event->end = $newEnd;
            $event->save();

            Log::info('Evento in calendario spotato di data', [
                'id' => $event->id,
                'title' => $event->title,
                'description' => $event->description,
                'start' => $event->start,
                'end' => $event->end,
                'is_available' => $event->is_available,
            ]);
        }
    }
    
    #[On('delete-event')]
    public function deleteEvent($eventId)
    {
        $event = Event::find($eventId);
        if ($event && $event->user_id === Auth::id()) {
            $event->delete();
            Log::info('Evento in calendario eliminato', [
                'id' => $event->id,
                'title' => $event->title,
                'description' => $event->description,
                'start' => $event->start,
                'end' => $event->end,
                'is_available' => $event->is_available,
            ]);
            $this->dispatch('event-deleted', $eventId);
        }
    }

    #[On('edit-event')]
    public function editEvent($eventId)
    {
        $event = Event::with('participants')->findOrFail($eventId);
        if ($event->user_id !== Auth::id()) {
            return;
        }
        $this->eventId = $event->id;
        $this->title = $event->title;
        $this->description = $event->description;
        $this->start_date = $event->start;
        $this->end_date = $event->end;
        $this->is_available = $event->is_available;
        $this->selectedParticipants = $event->participants->pluck('id')->toArray();
        $this->showCreateModal = true;
    }

    public function render()
    {
        return view('livewire.calendar.index-calendar');
    }
}
