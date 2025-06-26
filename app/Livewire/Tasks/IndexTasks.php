<?php

namespace App\Livewire\Tasks;

use App\Models\Project;
use App\Models\Task;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user();
        $projects = Project::query();

        if ($this->search) {
            $projects = $projects->where('name', 'like', '%' . $this->search . '%');
        }

        $projects = $projects->whereNotNull('team_id');

        if ($user && ($user->type === 'developer' || $user->type === 'project-manager')) {
            $teamIds = $user->teams->pluck('id');
            $projects = $projects->whereIn('team_id', $teamIds);
        }

        if ($user && ($user->type === 'developer' || $user->type === 'project-manager')) {
            $projects = $projects->withCount(['tasks' => function ($query) use ($user) {
                $query->where('developer_id', $user->id);
            }]);
        } else {
            $projects = $projects->withCount('tasks');
        }

        $projects = $projects->latest()->paginate(8);

        if ($user && ($user->type === 'developer' || $user->type === 'project-manager')) {
            $tasks = Task::where('developer_id', $user->id)->latest()->get();
        } else {
            $tasks = Task::latest()->get();
        }

        return view('livewire.tasks.index-tasks', compact('tasks', 'projects'));
    }
}
