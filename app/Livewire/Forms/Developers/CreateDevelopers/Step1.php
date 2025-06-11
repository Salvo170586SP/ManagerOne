<?php

namespace App\Livewire\Forms\Developers\CreateDevelopers;

use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;

class Step1 extends Form
{
    use WithFileUploads;

    public ?User $user;

    public $name;
    public $surname;
    public $phone;
    public $city;
    public $email;
    public $img_url = null;
    public $password = "password";

    protected $rules = [
        'name' => 'required',
        'surname' => 'required',
        'phone' => 'required',
        'city' => 'required',
        'email' => 'required|email',
    ];

    protected $messages = [
        'name.required' => 'Il campo è obbligatorio',
        'surname.required' => 'Il campo è obbligatorio',
        'phone.required' => 'Il campo è obbligatorio',
        'city.required' => 'Il campo è obbligatorio',
        'email.required' => 'Il campo è obbligatorio',
    ];
}
