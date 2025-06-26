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
        'description' => 'nullable|string',
        'developer_id' => 'nullable|exists:users,id',
        'priority' => 'required|in:low,medium,high',
        'due_date' => 'nullable|date|after:now',
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

        session()->flash('message', 'Task creata con successo!');

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

        $this->redirect("/tasks/$projectId/show", navigate: true);

        $this->reset();
    }

    public function render()
    {
        $developers = $this->project->team?->developers->map(function ($dev) {
            return [
                'id' => $dev->id,
                'name' => $dev->fullName(),
            ];
        }) ?? collect();
        
        $states =  config('managerOne.states_task');
        $priorities =  config('managerOne.priorities_task');

        return view('livewire.tasks.create-task', compact('developers','states','priorities'));
    }
}
