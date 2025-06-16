<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
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
        'developer_id' => 'required|exists:users,id',
        'priority' => 'required|in:low,medium,high',
        'due_date' => 'nullable|date|after:now',
    ];

    public function mount(Project $project)
    {
        $this->project = $project;
    }

    public function createTask()
    {
        $this->validate();

        $this->project->tasks()->create([
            'title' => $this->title,
            'developer_id' => $this->developer_id,
            'description' => $this->description,
            'priority' => $this->priority,
            'due_date' => $this->due_date,
            'status' => $this->state_task
        ]);

        session()->flash('message', 'Task creata con successo!');

        $this->redirect("/developers/$this->developer_id", navigate: true);

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
