<?php

namespace App\Livewire\Teams;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateTeam extends Component
{
    public $name;
    public $developer_ids = [];
    public $pm_id;
    public $is_available = false;


    protected $rules = [
        'pm_id' => 'required|exists:users,id,type,pm',
        'developer_ids' => 'required|array|max:4',
        'developer_ids.*' => 'exists:users,id,type,developer',
        'name' => 'required',
    ];

    protected $messages = [
        'name.required' => 'Il nome del team è obbligatorio',
        'pm_id.required' => 'Il Project Manager è obbligatorio',
        'pm_id.exists' => 'Il Project Manager selezionato non è valido',
        'developer_ids.max' => 'Non puoi aggiungere più di 5 developers al team',
        'developer_ids.*.exists' => 'Uno o più developers selezionati non sono validi',
        'developer_ids.required' => 'Devi selezionare almeno un developer',
    ];

    public function addTeam()
    {
        $this->validate();

        $team = Team::create([
            'admin_id' => Auth::id(),
            'name' => $this->name,
            'is_available' => $this->is_available,
        ]);

        $team->pms()->attach($this->pm_id);
        $team->developers()->attach($this->developer_ids);

        session()->flash('message', 'Team creato con successo');

        $this->reset();

        $this->redirect('/teams', navigate: true);
    }

    public function render()
    {
        $developers = User::where('type', 'developer')->get()->map(function ($dev) {
            return [
                'id' => $dev->id,
                'name' => $dev->fullName(),
            ];
        });

        $pms = User::where('category', 'project manager')->get()->map(function ($pm) {
            return [
                'id' => $pm->id,
                'name' => $pm->fullName(),
            ];
        });

        return view('livewire.teams.create-team', compact('developers', 'pms'));
    }
}
