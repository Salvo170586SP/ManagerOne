<?php

namespace App\Livewire\Tasks;

use App\Models\Project;
use App\Models\Task;
use Livewire\Component;

class IndexTasks extends Component
{
    public $search = "";
    public $searchDate;
    
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

    public function render()
    {
        $projects = Project::query();

        if ($this->search) {
            $projects = $projects->where('name', 'like', '%' . $this->search . '%');
        }

        if ($this->searchDate) {
            $projects = $projects->whereDate('created_at', '=', \Carbon\Carbon::parse($this->searchDate)->toDateString());
        }

        $projects = $projects->get();

        $tasks = Task::all();

        return view('livewire.tasks.index-tasks', compact('tasks', 'projects'));
    }
}
