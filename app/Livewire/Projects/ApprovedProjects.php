<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use App\Models\Team;
use Livewire\Component;

class ApprovedProjects extends Component
{
    public $search = "";
    public $searchDate = "";
    public $teamSelections = [];
    public $stateSelections = [];

    public function updatedTeamSelections($team_id, $project_id)
    {
        // Extract project ID from the key (format: "project-{id}")
        $projectId = explode('-', $project_id)[1];

        $project = Project::findOrFail($projectId);
        $project->team_id = $team_id;
        $project->save();

        if ($team_id) {
            $team = Team::findOrFail($team_id);
            session()->flash('message', "Team assegnato al progetto $project->name");
        } else {
            session()->flash('message', "Team rimosso dal progetto $project->name");
        }
    }

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
        $projects = Project::where('is_available', true);

        if ($this->search) {
            $projects = $projects->where('name', 'like', '%' . $this->search . '%');
        }

        if ($this->searchDate) {
            $projects = $projects->whereDate('created_at', '=', \Carbon\Carbon::parse($this->searchDate)->toDateString());
        }

        $projects = $projects->get();
        $teams = Team::all();

       /*  $states_project =  config('managerOne.states_project'); */
        $states_project = collect(config('managerOne.states_project'))->map(function ($state) {
            return [
                'name' => $state['name'],
                'value' => $state['name'],
                'color' => $state['color']
            ];
        })->toArray();

        
        // Initialize team selections for each project
        foreach ($projects as $project) {
            $this->teamSelections["project-{$project->id}"] = $project->team_id;
            $this->stateSelections["project-{$project->id}"] = in_array($project->state, array_column($states_project, 'name'))
            ? $project->state
            : null;
        }

        $currentState = collect($states_project)->firstWhere('name', $this->stateSelections["project-{$project->id}"]);
        $selectColor = $currentState ? $currentState['color'] : 'bg-white';
        
        return view('livewire.projects.approved-projects', compact('projects', 'teams', 'states_project', 'selectColor'));
    }
}
