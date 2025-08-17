<?php

namespace App\Livewire\Clients\Components;

use Livewire\Component;

class TableProjectsShow extends Component
{
    public $client;

    public function getStateName($state)
    {
        $projectData = collect(config('managerOne.states_project'))->firstWhere('id', $state);
        return $projectData['name'] ?? $state;
    }

    public function getStateColor($state)
    {
        $projectData = collect(config('managerOne.states_project'))->firstWhere('id', $state);
        return $projectData['color'] ?? 'bg-gray-300';
    }

    public function render()
    {
        $projectClient = $this->client->projects()->paginate(3);

        return view('livewire.clients.components.table-projects-show', compact('projectClient'));
    }
}
