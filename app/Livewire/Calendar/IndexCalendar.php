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

        if ($user->hasRole('developer')) {
            // Eventi dove è partecipante o creatore
            $events = Event::with(['participants', 'creator'])
                ->whereHas('participants', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->orWhere('user_id', $user->id)
                ->get();
        } else {
            // Eventi dove è creatore o partecipante (tutti)
            $events = Event::with(['participants', 'creator'])
                ->where('user_id', $user->id)
                ->orWhereHas('participants', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->get();
        }

        $this->events = $events->map(function ($event) {
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

        // Controllo ruolo developer
        if ($user->hasRole('developer')) {
            $this->tasks = Task::where('developer_id', $user->id)->get()->toArray();
        } else if ($user->hasRole('project_manager')) {
            // Recupera tutti i team dell'utente
            $teams = $user->teams;
            // Filtra solo i team dove l'utente ha type 'project_manager'
            $pmTeams = $teams->filter(function($team) use ($user) {
                return $user->type === 'project_manager';
            });
            // Recupera tutti i progetti di questi team
            $projectIds = [];
            foreach ($pmTeams as $team) {
                $projectIds = array_merge($projectIds, $team->projects->pluck('id')->toArray());
            }
            // Recupera tutte le tasks di questi progetti
            $this->tasks = Task::whereIn('project_id', $projectIds)->get()->toArray();
        }
    }

    #[On('calendar-select')]
    public function showCreateModal($dateInfo)
    {
        $user = Auth::user();
        if (!$user->hasRole('super_admin')) {
            return;
        }
        $this->resetForm();
        $this->start_date = $dateInfo['startStr'];
        $this->end_date = $dateInfo['endStr'];
        $this->showCreateModal = true;
    }

    protected $rules = [
        'title' => 'required|string|max:255',
        'start_date' => 'required|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'description' => 'nullable|string|max:255',
        'selectedParticipants' => 'nullable'
    ];

    protected $messages = [
        'title.required' => 'Il campo è obbligatorio',
        'title.max' => 'Il campo può avere massimo 255 caratteri',
        'start_date.required' => 'Il campo è obbligatorio',
        'start_date.date' => 'Il campo deve essere una data',
        'end_date.required' => 'Il campo è obbligatorio',
        'end_date.date' => 'Il campo deve essere una data',
        'description.max' => 'Il campo può avere massimo 255 caratteri',
    ];

    public function saveEvent()
    {
        $this->validate();

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

            session()->flash('message', "Evento modificato con successo");
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
            // Invio la notifica agli utenti invitati
            foreach ($participants as $participant) {
                $participant->notify(new \App\Notifications\EventInvited($event));
            }
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

            session()->flash('message', "Evento creato con successo");

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
        $user = Auth::user();
        if (!$user->hasRole('super_admin')) {
            return;
        }

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

        session()->flash('message', "Data dell evento modificata con successo");
    }
    
    #[On('delete-event')]
    public function deleteEvent($eventId)
    {
        $user = Auth::user();
        if (!$user->hasRole('super_admin')) {
            return;
        }

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

        session()->flash('message', "Evento eliminato con successo");
    }

    #[On('edit-event')]
    public function editEvent($eventId)
    {
        $user = Auth::user();
        if (!$user->hasRole('super_admin')) {
            return;
        }
        
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
        $tasksForJs = array_map(function($task) {
            return [
                'id' => $task['id'],
                'title' => $task['title'],
                'description' => $task['description'] ?? '',
                'created_at' => $task['created_at'],
                'due_date' => $task['due_date'],
                'completed_at' => $task['completed_at'] ?? null,
                'developer_name' => isset($task['developer_id']) && $task['developer_id']
                    ? (\App\Models\User::find($task['developer_id'])->name ?? 'N/D')
                    : 'N/D',
            ];
        }, $this->tasks);
        return view('livewire.calendar.index-calendar', [
            'events' => $this->events,
            'tasksForJs' => $tasksForJs,
        ]);
    }
}
