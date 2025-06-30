<?php

namespace App\Livewire\Developers;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditDevelopers extends Component
{
    use WithFileUploads;
    
    public ?User $developer;

    public $name;
    public $surname;
    public $phone;
    public $city;
    public $img_url = null;
    public $password = "password";
    public $category;
    public $workplace;
    public $level;
    public $categories;
    public $workplaces;
    public $levels;

    public function mount()
    {
        $this->categories = config('managerOne.categories');
        $this->workplaces = config('managerOne.workplaces');
        $this->levels = config('managerOne.levels');

        $this->name = $this->developer->name;
        $this->surname = $this->developer->surname;
        $this->phone = $this->developer->phone;
        $this->city = $this->developer->city;
        $this->category = $this->developer->category;
        $this->workplace = $this->developer->workplace;
        $this->level = $this->developer->level;

        if ($this->developer->img_url) {
            $this->img_url = asset('storage/' . $this->developer->img_url);
        }
    }

    protected $rules = [
        'name' => 'required',
        'surname' => 'required',
        'phone' => 'required',
        'city' => 'required',
        'category' => 'required',
        'workplace' =>  'required',
        'level' => 'required',

    ];

    protected $messages = [
        'name.required' => 'Il campo è obbligatorio',
        'surname.required' => 'Il campo è obbligatorio',
        'phone.required' => 'Il campo è obbligatorio',
        'city.required' => 'Il campo è obbligatorio',
        'category.required' => 'Il campo è obbligatorio',
        'workplace.required' => 'Il campo è obbligatorio',
        'level.required' => 'Il campo è obbligatorio',
    ];

    public function editDeveloper()
    {
        $this->validate();

        // Gestione dell'immagine
        $url = $this->developer->img_url;  // MantieneF l'URL esistente come default

        // Se è stata caricata una nuova immagine
        if ($this->img_url && !is_string($this->img_url)) {
            // Se esiste già un'immagine, la eliminiamo
            if ($this->developer->img_url) {
                Storage::disk('public')->delete($this->developer->img_url);
            }
            // Salva la nuova immagine
            $url = $this->img_url->store('imgsDeveloper', 'public');
        }

        $this->developer->update([
            'name' => $this->name,
            'surname' => $this->surname,
            'img_url' => $url,
            'phone' => $this->phone,
            'city' => $this->city,
            'password' => $this->password,
            'category' => $this->category,
            'workplace' => $this->workplace,
            'level' => $this->level,
        ]);


        Log::info('Developer modificato', [
            'id' => $this->developer->id,
            'name' => $this->developer->name,
            'surname' => $this->developer->surname,
            'img_url' => $this->developer->img_url,
            'phone' => $this->developer->phone,
            'city' => $this->developer->city,
            'type' => $this->developer->type,
            'email' => $this->developer->email,
            'category' => $this->developer->category,
            'workplace' => $this->developer->workplace,
            'level' => $this->developer->level,
        ]);


        session()->flash('message', 'Developer modificato con successo!');

        return $this->redirect('/developers', navigate: true);
    }
    public function render()
    {
        return view('livewire.developers.edit-developers');
    }
}
