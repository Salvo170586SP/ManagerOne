<?php

namespace App\Livewire\Clients;

use App\Jobs\GenerateIdClient;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;

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
        'phone' => 'required',
        'city' => 'required',
        'type' => 'required',
        'email' => 'required',
        'password' => 'required',
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

        $this->redirect('/clients', navigate: true);
    }

    public function render()
    {
        return view('livewire.clients.create-clients');
    }
}
