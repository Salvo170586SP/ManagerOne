<?php

namespace App\Livewire\Forms\Developers\CreateDevelopers;

use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Form;

class Step3 extends Form
{
    public ?User $user;

    public $category;
    public $workplace;
    public $level;

    protected $rules = [
        'category' => 'nullable',
        'workplace' =>  'required',
        'level' => 'required',
    ];

    protected $messages = [
        'workplace.required' => 'Il campo è obbligatorio',
        'level.required' => 'Il campo è obbligatorio',
    ];
}
