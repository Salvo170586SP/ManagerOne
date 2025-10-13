<?php

namespace App\Livewire\Clients;

use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class IndexClients extends Component
{
    use WithPagination;

    public $search = "";
    public $searchDate;
    public $searchCity;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSearchCity()
    {
        $this->resetPage();
    }

    public function updatedSearchDate()
    {
        $this->resetPage();
    }

    public function deleteClient($client_id)
    {
        $client = User::findOrFail($client_id);
        // Check if client is referenced in projects
        $hasProjects = Project::where('client_id', $client_id)->exists();

        if ($hasProjects) {
            session()->flash('error', 'Non puoi eliminare il cliente finchè avrà un progetto associato. Elimina il progetto associato');
            return;
        }

        if ($client) {
            if (!empty($client->img_url)) {
                if (Storage::disk('public')->exists($client->img_url)) {
                    Storage::disk('public')->delete($client->img_url);
                }
            }

            $client->delete();


            Log::info('Cliente eliminato', [
                'user_id' => Auth::id(),
                'client_id' => $client->id,
                'client_name' => $client->name,
                'client_surname' => $client->surname,
            ]);
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

        $clients = $clients->where('type', 'client')->latest()->paginate(10);
       /*  $pollCondition = User::where('type', 'client')->whereNull('IdClient')->exists(); */

        // Ottieni la lista delle città disponibili per il filtro
        $cities = User::where(function ($query) {
            $query->where('type', 'client');
        })
            ->whereNotNull('city')
            ->distinct()
            ->pluck('city')
            ->filter()
            ->values();

        return view('livewire.clients.index-clients', compact('clients', 'cities'));
    }
}
