<?php

namespace App\Livewire\Tasks;

use App\Models\Project;
use App\Models\Task;
use Livewire\Component;
use Livewire\WithPagination;

class IndexTasks extends Component
{
    use WithPagination;
    public $search = "";
 
    public function updatedSearch()
    {
        $this->resetPage();
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

    public function render()
    {
        $projects = Project::query();

        if ($this->search) {
            $projects = $projects->where('name', 'like', '%' . $this->search . '%');
        }

        $projects = $projects->whereNotNull('team_id')->get();

        $tasks = Task::latest()->paginate(10);

        return view('livewire.tasks.index-tasks', compact('tasks', 'projects'));
    }
}
