<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;

class IndexProjects extends Component
{
    use WithPagination;

    public $search = "";
    public $searchDate = "";
    public $searchAvailable;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSearchDate()
    {
        $this->resetPage();
    }
 
    public function updatedSearchAvailable()
    {
        $this->resetPage();
    }

    public function deleteProject($project_id)
    {
        $project = Project::findOrFail($project_id);

        if ($project) {
            $project->delete();
        }

        return $this->redirect('/projects', navigate: true);
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

        if ($this->searchAvailable !== null && $this->searchAvailable !== '') {
            $projects = $projects->where('is_available', (int) $this->searchAvailable);
        }
        
        $projects = $projects->latest()->paginate(10);
        
        $pollCondition = Project::whereNull('IdProject')->exists();

        return view('livewire.projects.index-projects', compact('projects', 'pollCondition'));
    }
}
