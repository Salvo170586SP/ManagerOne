<?php

namespace App\Livewire\Clients;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ShowClients extends Component
{
    use WithPagination;

    public $client;

    public function mount(User $client)
    {
        $this->client = $client;
    }

    public function render()
    {
        return view('livewire.clients.show-clients');
    }
}
