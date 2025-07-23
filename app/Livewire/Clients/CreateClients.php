<?php

namespace App\Livewire\Clients;

use App\Jobs\GenerateIdClient;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CreateClients extends Component
{
    use WithFileUploads;

    public $name;
    public $surname;
    public $img_url = null;
    public $phone;
    public $city;
    public $type = "client";
    public $email;
    public $password = "password";

    protected $rules = [
        'name' => 'required',
        'surname' => 'required',
        'img_url' => 'nullable',
        'phone' => 'required|numeric',
        'city' => 'required',
        'type' => 'required',
        'email' => 'required',
    ];

    protected $messages = [
        'name.required' => 'Il campo è obbligatorio',
        'surname.required' => 'Il campo è obbligatorio',
        'phone.required' => 'Il campo è obbligatorio',
        'phone.numeric' => 'Il campo accetta solo mnumeri',
        'city.required' => 'Il campo è obbligatorio',
        'type.required' => 'Il campo è obbligatorio',
        'email.required' => 'Il campo è obbligatorio',
    ];

    public function submit()
    {
        $url = null;

        if ($this->img_url) {
            $url = $this->img_url->store('imgsClient', 'public');
        }

        $this->validate();

        $client =  User::create([
            'name' => $this->name,
            'surname' => $this->surname,
            'img_url' => $url,
            'phone' => $this->phone,
            'city' => $this->city,
            'type' => $this->type,
            'email' => $this->email,
            'password' => $this->password,
        ])->assignRole('client');

        GenerateIdClient::dispatch($client);

        session()->flash('message', 'Cliente creato con successo');

        $this->reset();

        Log::info('Cliente aggiunto', [
            'user_id' => Auth::id(),
            'client_id' => $client->id,
            'client_name' => $client->name,
            'client_surname' => $client->surname,
        ]);

        $this->redirect('/clients', navigate: true);
    }

    public function render()
    {
        return view('livewire.clients.create-clients');
    }
}
