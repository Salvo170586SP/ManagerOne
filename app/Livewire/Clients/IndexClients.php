<?php

namespace App\Livewire\Clients;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class IndexClients extends Component
{
    public $search = "";
    public $searchDate;
    public $searchCity;

    public function deleteClient($client_id)
    {
        $client = User::findOrFail($client_id);

        if ($client) {

            if (!empty($client->img_url)) {
                if (Storage::disk('public')->exists($client->img_url)) {
                    Storage::disk('public')->delete($client->img_url);
                }
            }

            $client->delete();
        }

        return $this->redirect('/clients', navigate: true);
    }

    public function render()
    {
        $clients = User::query();

        if ($this->search) {
            $clients = $clients->where('name', 'like', '%' . $this->search . '%');
        }

        if ($this->searchCity) {
            $clients = $clients->where('city', 'like', '%' . $this->searchCity . '%');
        }

        if ($this->searchDate) {
            $clients = $clients->whereDate('created_at', '=', \Carbon\Carbon::parse($this->searchDate)->toDateString());
        }

        $clients = $clients->where('type', 'client')->get();

        return view('livewire.clients.index-clients', compact('clients'));
    }
}
