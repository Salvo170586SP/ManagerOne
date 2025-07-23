<?php

namespace App\Livewire\Dashboard;

use App\Models\Project;
use Livewire\Component;

class ChartTotalProjects extends Component
{
    public $totalProjects;
    public $approved;
    public $notApproved;
    public $pendingApproval;
    public $delivered;
    public $hasProjects;


    public function mount()
    {
        $this->totalProjects = Project::count();
        $this->approved = Project::where('is_approved', 'approved')->count();
        $this->notApproved = Project::where('is_approved', 'not_approved')->count();
        $this->pendingApproval = Project::where('is_approved', 'pending_approval')->count();
        $this->delivered = Project::where('state', 'delivered')->count();
        $this->hasProjects = ($this->approved + $this->notApproved + $this->pendingApproval) > 0;
    }

    public function render()
    {
        return view('livewire.dashboard.chart-total-projects');
    }
}
