<?php

namespace App\Livewire\Tasks;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class EditTask extends Component
{
    public $task;
    public $project;

    public $title = '';
    public $description = '';
    public $developer_id;
    public $priority = '';
    public $due_date = '';
    public $state_task;

    public function mount(Task $task, Project $project)
    {
        $this->task = $task;
        $this->title = $task->title;
        $this->description = $task->description;
        $this->developer_id = $task->developer_id;
        $this->priority = $task->priority;
        $this->due_date = $task->due_date;
        $this->state_task = $task->status;

        $this->project = $project;
    }

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

    public function updateTask()
    {
        $this->validate();

        $this->task->update([
            'title' => $this->title,
            'developer_id' => $this->developer_id,
            'description' => $this->description,
            'priority' => $this->priority,
            'due_date' => $this->due_date,
            'status' => $this->state_task
        ]);

        
        Log::info('Task modificata', [
            'id' =>  $this->task->id,
            'title' => $this->task->title,
            'developer_id' => $this->task->developer_id,
            'description' => $this->task->description,
            'priority' => $this->task->priority,
            'due_date' => $this->task->due_date,
            'status' => $this->task->status,
            'created_by' => Auth::id(),
            'project_id' => $this->project->id,
        ]);
        
        $projectId = $this->project->id;
        
        $this->reset();

        session()->flash('message', 'Task modificata con successo!');
        
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

        return view('livewire.tasks.edit-task', compact('developers', 'states', 'priorities'));
    }
}
