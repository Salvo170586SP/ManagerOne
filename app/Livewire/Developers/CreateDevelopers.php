<?php

namespace App\Livewire\Developers;

use App\Jobs\GenerateIdDev;
use App\Livewire\Forms\Developers\CreateDevelopers\Step1;
use App\Livewire\Forms\Developers\CreateDevelopers\Step2;
use App\Livewire\Forms\Developers\CreateDevelopers\Step3;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateDevelopers extends Component
{
    use WithFileUploads;

    public $currentStep = 1;
    public $categories;
    public $workplaces;
    public $levels;
    public $types;

    public Step1 $developerStep1;
    public Step2 $developerStep2;
    public Step3 $developerStep3;

    

    public function mount()
    {
        $this->categories = config('managerOne.categories');
        $this->workplaces = config('managerOne.workplaces');
        $this->levels = config('managerOne.levels');
        $this->types = config('managerOne.types');
    }

    public function addStep()
    {
        if ($this->currentStep === 1) {
            $this->developerStep1->validate();
        } elseif ($this->currentStep === 2) {
            $this->developerStep2->validate();
        }
        
        $this->currentStep++;
    }

    public function backStep()
    {
        $this->currentStep--;
    }

    public function createDeveloper()
    {
        $this->developerStep3->validate();

        //salvo la foto di profilo
        $url = null;
        if ($this->developerStep2->img_url) {
            $url = $this->developerStep2->img_url->store('imgsDeveloper', 'public');
        }

        $dev = User::create([
            'name' => $this->developerStep2->name,
            'surname' => $this->developerStep2->surname,
            'img_url' => $url,
            'phone' => $this->developerStep2->phone,
            'city' => $this->developerStep2->city,
            'type' => $this->developerStep1->type,
            'email' => $this->developerStep2->email,
            'password' => $this->developerStep2->password,
            'category' => $this->developerStep3->category,
            'workplace' => $this->developerStep3->workplace,
            'level' => $this->developerStep3->level,
        ]);

        GenerateIdDev::dispatch($dev);

        $dev->assignRole($dev->type);

        Log::info('Developer creato', [
            'id' => $dev->id,
            'name' => $dev->name,
            'surname' => $dev->surname,
            'img_url' => $dev->img_url,
            'phone' => $dev->phone,
            'city' => $dev->city,
            'type' => $dev->type,
            'email' => $dev->email,
            'category' => $dev->category,
            'workplace' => $dev->workplace,
            'level' => $dev->level,
        ]);

        session()->flash('message', 'Developer creato con successo!');

        return $this->redirect('/developers', navigate: true);
    }

    public function render()
    {
        return view('livewire.developers.create-developers');
    }
}
