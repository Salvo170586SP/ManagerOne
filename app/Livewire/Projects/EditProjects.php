<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use App\Models\User;
use Livewire\Component;

class EditProjects extends Component
{
    public $project;
    public $client_id;
    public $name;
    public $description;
    public $preventive;
    public $end_date;
    public $is_available = false;

    protected $rules = [
        'client_id' => 'required',
        'name' => 'required',
        'description' => 'nullable',
        'end_date' => 'required|date|after:now',
        'preventive' => 'required|numeric|min:0|max:999999.99',
    ];

    public function mount(Project $project)
    {
        $this->project = $project;
        $this->client_id = $project->client_id;
        $this->name = $project->name;
        $this->description = $project->description;
        $this->preventive = $project->preventive;
        $this->end_date = $project->end_date;
        $this->is_available = (bool) $project->is_available;
    }

    public function editProject()
    {
        $this->validate();

        $this->project->update([
            'client_id' => $this->client_id,
            'name' => $this->name,
            'description' => $this->description,
            'end_date' => $this->end_date,
            'preventive' => $this->preventive ?? 0.00,
            'is_available' => $this->is_available,
        ]);

        session()->flash('message', 'Progetto modificato con successo');

        $this->reset();

        $this->redirect('/projects', navigate: true);
    }

    public function render()
    {
        $clients = User::where('type', 'client')->get()->map(function ($client) {
            return [
                'id' => $client->id,
                'name' => $client->fullname(),
            ];
        });

        return view('livewire.projects.edit-projects', compact('clients'));
    }
}
