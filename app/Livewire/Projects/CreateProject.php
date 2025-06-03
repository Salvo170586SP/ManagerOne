<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use App\Models\User;
use Livewire\Component;

class CreateProject extends Component
{
    public $client_id;
    public $name;
    public $description;
    public $preventive;
    public $is_available = false;

    protected $rules = [
        'client_id' => 'required',
        'name' => 'required',
        'description' => 'nullable',
        'preventive' => 'nullable',
    ];

    public function submit()
    {
        $this->validate();

        Project::create([
            'client_id' => $this->client_id,
            'name' => $this->name,
            'description' => $this->description,
            'preventive' => $this->preventive ?? 0.00,
            'is_available' => $this->is_available,
        ]);

        session()->flash('message', 'Progetto creato con successo');

        $this->reset();

        $this->redirect('/projects', navigate: true);
    }

    public function render()
    {
        $clients = User::where('type', 'client')->get()->map(function ($client) {
            return [
                'id' => $client->id,
                'name' => $client->fullName(),
            ];
        });

        return view('livewire.projects.create-project', compact('clients'));
    }
}
