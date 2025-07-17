<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use App\Notifications\TaskAssigned;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class CreateTask extends Component
{
    public Project $project;
    public $title = '';
    public $description = '';
    public $developer_id;
    public $priority = '';
    public $due_date = '';
    public $state_task;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string|max:255',
        'developer_id' => 'required|exists:users,id',
        'priority' => 'required|in:low,medium,high',
        'state_task' => 'required',
        'due_date' => 'required|date|after:now',
    ];

    protected $messages = [
        'title.required' => 'Il campo è obbligatorio',
        'title.max' => 'Il campo può contenere massimo 255 caratteri',
        'description.max' => 'Il campo può contenere massimo 255 caratteri',
        'developer_id.required' => 'Il campo è obbligatorio',
        'priority.required' => 'Il campo è obbligatorio',
        'state_task.required' => 'Il campo è obbligatorio',
        'due_date.required' => 'Il campo è obbligatorio',
        'due_date.date' => 'Il campo deve essere una data',
        'due_date.after' => 'Il campo deve avere minimo la data odierna',
    ];

    public function mount(Project $project)
    {
        $this->project = $project;
    }

    public function createTask()
    {
        $user = Auth::user();
        // Se developer, imposta developer_id ad Auth::id()
        if ($user && $user->type === 'developer') {
            $this->developer_id = $user->id;
        }
        $this->validate();

        $task = $this->project->tasks()->create([
            'title' => $this->title,
            'developer_id' => $this->developer_id,
            'description' => $this->description,
            'priority' => $this->priority,
            'due_date' => $this->due_date,
            'status' => $this->state_task
        ]);

        // Trova lo sviluppatore e invia la notifica
        $developer = User::find($this->developer_id);
        if ($developer) {
            $developer->notify(new TaskAssigned($task));
        }

        
        Log::info('Task creata', [
            'id' => $task->id,
            'title' => $task->title,
            'developer_id' => $task->developer_id,
            'description' => $task->description,
            'priority' => $task->priority,
            'due_date' => $task->due_date,
            'status' => $task->status,
            'created_by' => Auth::id(),
            'project_id' => $this->project->id,
        ]);
        
        $projectId = $this->project->id;
        
        $this->reset();
        
        session()->flash('message', 'Task creata con successo');

        $this->redirect("/tasks/$projectId/show", navigate: true);
    }

    public function render()
    {
        $developers = $this->project->team?->developers->map(function ($dev) {
            return [
                'id' => $dev->id,
                'name' => $dev->fullName(),
            ];
        }) ?? collect();

        $states =  array_slice(config('managerOne.states_task'), 0, 2);
        $priorities =  config('managerOne.priorities_task');

        return view('livewire.tasks.create-task', compact('developers', 'states', 'priorities'));
    }
}
