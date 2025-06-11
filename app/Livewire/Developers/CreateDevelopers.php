<?php

namespace App\Livewire\Developers;

use App\Livewire\Forms\Developers\CreateDevelopers\Step1;
use App\Livewire\Forms\Developers\CreateDevelopers\Step2;
use App\Models\User;
use Livewire\Component;

class CreateDevelopers extends Component
{
    public $currentStep = 1;
    public $categories;
    public $workplaces;
    public $levels;
    public $types;

    public Step1 $developerStep1;
    public Step2 $developerStep2;

    public function mount()
    {
        $this->categories = config('managerOne.categories');
        $this->workplaces = config('managerOne.workplaces');
        $this->levels = config('managerOne.levels');
        $this->types = config('managerOne.types');
    }

    public function addStep()
    {
        /* $this->developerStep1->validate(); */
        $this->currentStep++;
    }

    public function backStep()
    {
        $this->currentStep--;
    }

    public function createDeveloper()
    {
        $this->developerStep2->validate();

        //salvo la foto di profilo
        $url = null;
        if ($this->developerStep1->img_url) {
            $url = $this->developerStep1->img_url->store('imgsDeveloper');
        }

        $user = User::create([
            'name' => $this->developerStep1->name,
            'surname' => $this->developerStep1->surname,
            'img_url' => $url,
            'phone' => $this->developerStep1->phone,
            'city' => $this->developerStep1->city,
            'type' => $this->developerStep2->type,
            'email' => $this->developerStep1->email,
            'password' => $this->developerStep1->password,
            'category' => $this->developerStep2->category,
            'workplace' => $this->developerStep2->workplace,
            'level' => $this->developerStep2->level,
        ]);

        $user->assignRole($user->type);
    
        session()->flash('message', 'Developer creato con successo!');

        return $this->redirect('/developers', navigate: true);
    }

    public function render()
    {
        return view('livewire.developers.create-developers');
    }
}
