<?php

namespace App\Livewire\Dashboard;

use App\Models\Project;
use Livewire\Component;

class ChartTotalProjects extends Component
{
    public $totalProjects;
    public $approved;
    public $notApproved;
    public $delivered;
    public $hasProjects;


    public function mount()
    {
        $this->totalProjects = Project::count();
        $this->approved = Project::where('is_available', 1)->count();
        $this->notApproved = Project::where('is_available', 0)->count();
        $this->delivered = Project::where('state', 'delivered')->count();
        $this->hasProjects = ($this->approved + $this->notApproved) > 0;
    }

    public function render()
    {
        return view('livewire.dashboard.chart-total-projects');
    }
}
