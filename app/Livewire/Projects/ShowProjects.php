<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Livewire\Component;

class ShowProjects extends Component
{
    public $project;

    public function mount(Project $project)
    {
        $this->project = $project;
    }
   
    public function render()
    {
        return view('livewire.projects.show-projects');
    }
}
