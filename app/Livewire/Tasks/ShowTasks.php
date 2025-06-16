<?php

namespace App\Livewire\Tasks;

use App\Models\Project;
use Livewire\Component;

class ShowTasks extends Component
{
    public $project;

    public function mount(Project $project)
    {
        $this->project = $project;
    }

    public function getStateName($state)
    {
        $projectData = collect(config('managerOne.states_project'))->firstWhere('id', $state);
        return $projectData['name'] ?? $state;
    }

    public function getStateColor($state)
    {
        $projectData = collect(config('managerOne.states_project'))->firstWhere('id', $state);
        return $projectData['color'] ?? 'bg-gray-300';
    }
  
    public function getPriorityName($priority)
    {
        $taskData = collect(config('managerOne.priorities_task'))->firstWhere('id', $priority);
        return $taskData['name'] ?? $priority;
    }

    public function getPriorityColor($priority)
    {
        $taskData = collect(config('managerOne.priorities_task'))->firstWhere('id', $priority);
        return $taskData['color'] ?? 'bg-gray-300';
    }
    
    public function render()
    {
        return view('livewire.tasks.show-tasks');
    }
}
