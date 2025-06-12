<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Livewire\Component;

class DeliveredProjects extends Component
{
    public $search = "";
    public $searchDate = "";
    public $teamSelections = [];
    public $stateSelections = [];

    public function updatedStateSelections($state, $project_id)
    {
        // Extract project ID from the key (format: "project-{id}")
        $projectId = explode('-', $project_id)[1];

        $project = Project::findOrFail($projectId);
        $project->state = $state;
        $project->save();

        session()->flash('message', "Stato del progetto aggiornato con successo");
    }


    public function render()
    {
        $projects = Project::where('state', 'Consegnato');

        if ($this->search) {
            $projects = $projects->where('name', 'like', '%' . $this->search . '%');
        }

        if ($this->searchDate) {
            $projects = $projects->whereDate('created_at', '=', \Carbon\Carbon::parse($this->searchDate)->toDateString());
        }

        $projects = $projects->get();
 
       /*  $states_project =  config('managerOne.states_project'); */
        $states_project = collect(config('managerOne.states_project'))->map(function ($state) {
            return [
                'name' => $state['name'],
                'value' => $state['name'],
                'color' => $state['color']
            ];
        })->toArray();

        $selectColors = [];
        
        // Initialize state selections for each project
        foreach ($projects as $project) {
            $this->stateSelections["project-{$project->id}"] = in_array($project->state, array_column($states_project, 'name'))
                ? $project->state
                : null;
                
            $currentState = collect($states_project)->firstWhere('name', $this->stateSelections["project-{$project->id}"]);
            $selectColors[$project->id] = $currentState ? $currentState['color'] : 'bg-white';
        }

        return view('livewire.projects.delivered-projects', compact('projects', 'states_project', 'selectColors'));
    }
}
