<?php

namespace App\Livewire\Clients;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class EditClients extends Component
{
    use WithFileUploads;

    public $client;
    public $name;
    public $surname;
    public $img_url;
    public $phone;
    public $city;

    protected $rules = [
        'name' => 'required',
        'surname' => 'required',
        'img_url' => 'nullable',
        'phone' => 'required|numeric',
        'city' => 'required',
    ];

    protected $messages = [
        'name.required' => 'Il campo è obbligatorio',
        'surname.required' => 'Il campo è obbligatorio',
        'phone.required' => 'Il campo è obbligatorio',
        'phone.numeric' => 'Il campo accetta solo mnumeri',
        'city.required' => 'Il campo è obbligatorio',
    ];

    public function mount(User $client)
    {
        $this->client = $client;
        $this->name = $client->name;
        $this->surname = $client->surname;
        $this->phone = $client->phone;
        $this->city = $client->city;

        if ($client->img_url) {
            $this->img_url = asset('storage/' . $client->img_url);
        }
    }


    public function editClient()
    {
        // Gestione dell'immagine
        $url = $this->client->img_url;  // MantieneF l'URL esistente come default

        // Se è stata caricata una nuova immagine
        if ($this->img_url && !is_string($this->img_url)) {
            // Se esiste già un'immagine, la eliminiamo
            if ($this->client->img_url) {
                Storage::disk('public')->delete($this->client->img_url);
            }
            // Salva la nuova immagine
            $url = $this->img_url->store('imgsClient', 'public');
        }

        $this->validate();

        $this->client->update([
            'name' => $this->name,
            'surname' => $this->surname,
            'img_url' => $url,
            'phone' => $this->phone,
            'city' => $this->city,
        ]);

        Log::info('Cliente modificato', [
            'user_id' => Auth::id(),
            'client_id' => $this->client->id,
            'client_name' => $this->client->name,
            'client_surname' => $this->client->surname,
        ]);

        session()->flash('message', 'Cliente aggiornato con successo');

        $this->redirect('/clients', navigate: true);
    }

    public function deleteImg()
    {
        if ($this->client->img_url) {
            Storage::disk('public')->delete($this->client->img_url);
            $this->client->img_url = null;
            $this->client->save();
            $this->img_url = null;
            $this->dispatch('img-deleted');
        }

        session()->flash('message', 'Immagine del cliente eliminata con successo');
    }

    public function render()
    {
        return view('livewire.clients.edit-clients');
    }
}
