<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Livewire\Component;

class ApprovedProjects extends Component
{
    public $search = "";
    public $searchDate = "";
    public $searchAvailable;

    public function render()
    {

        $projects = Project::where('is_available', true);

        if ($this->search) {
            $projects = $projects->where('name', 'like', '%' . $this->search . '%');
        }

        if ($this->searchDate) {
            $projects = $projects->whereDate('created_at', '=', \Carbon\Carbon::parse($this->searchDate)->toDateString());
        }

        if ($this->searchAvailable !== null && $this->searchAvailable !== '') {
            $projects = $projects->where('is_available', (int) $this->searchAvailable);
        }

        $projects = $projects->get();

        return view('livewire.projects.approved-projects', compact('projects'));
    }
}
