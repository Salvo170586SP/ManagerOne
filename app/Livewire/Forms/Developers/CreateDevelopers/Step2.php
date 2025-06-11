<?php

namespace App\Livewire\Forms\Developers\CreateDevelopers;

use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Form;

class Step2 extends Form
{
    public ?User $user;

    public $category;
    public $workplace;
    public $level;
    public $type;

    protected $rules = [
        'category' => 'required',
        'workplace' =>  'required',
        'level' => 'required',
        'type' => 'required',
    ];

    protected $messages = [
        'category.required' => 'Il campo è obbligatorio',
        'workplace.required' => 'Il campo è obbligatorio',
        'level.required' => 'Il campo è obbligatorio',
        'type.required' => 'Il campo è obbligatorio',
    ];
}
