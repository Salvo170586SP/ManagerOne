<?php

namespace App\Livewire\Clients;

use App\Models\User;
use Livewire\Component;

class ShowClients extends Component
{
    public $client;

    public function mount(User $client)
    {
        $this->client = $client;
    }

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
        return view('livewire.clients.show-clients');
    }
}
