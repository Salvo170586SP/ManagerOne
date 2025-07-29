<?php

namespace App\Livewire\Forms\Developers\CreateDevelopers;

use App\Models\User;
use Livewire\Form;
use Livewire\WithFileUploads;

class Step1 extends Form
{
    use WithFileUploads;

    public ?User $user;

    public $type;

    protected $rules = [
        'type' => 'required',
    ];

    protected $messages = [
        'type.required' => 'Devi selezionare uno dei 2 tipi di utente',
    ];
}
