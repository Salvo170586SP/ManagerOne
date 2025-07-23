<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class NotApprovedProjects extends Component
{
    use WithPagination;

    public $search = "";
    public $searchDate = "";

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSearchDate()
    {
        $this->resetPage();
    }


    public function render()
    {
        $query = Project::where('is_approved', 'not_approved');

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        if ($this->searchDate) {
            $query->whereDate('created_at', '=', \Carbon\Carbon::parse($this->searchDate)->toDateString());
        }

        $projectsNotApproved = $query->latest()->paginate(10);

        return view('livewire.projects.not-approved-projects', compact('projectsNotApproved'));
    }
}
