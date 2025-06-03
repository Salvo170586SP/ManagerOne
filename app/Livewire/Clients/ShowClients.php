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
   
    public function render()
    {
        return view('livewire.clients.show-clients');
    }
}
