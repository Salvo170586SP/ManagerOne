<?php

namespace App\Livewire\Teams;

use App\Models\Team;
use App\Models\User;
use Livewire\Component;

class EditTeam extends Component
{
    public $team;
    public $name;
    public $pm_id = [];
    public $developer_ids = [];
    public $is_available = false;
    
    protected $rules = [
        'name' => 'required|string|max:255',
        'pm_id' => 'required|exists:users,id,type,project_manager',
        'developer_ids' => 'array|max:4',
        'developer_ids.*' => 'exists:users,id,type,developer',
    ];

    protected $messages = [
        'name.required' => 'Il nome del team è obbligatorio',
        'pm_id.required' => 'Il Project Manager è obbligatorio',
        'pm_id.exists' => 'Il Project Manager selezionato non è valido',
        'developer_ids.max' => 'Non puoi aggiungere più di 5 developers al team',
        'developer_ids.*.exists' => 'Uno o più developers selezionati non sono validi',
    ];

    public function mount(Team $team)
    {
        $this->team = $team;
        $this->name = $team->name;
        $this->pm_id = $team->pms->first()?->id;
        $this->is_available = (bool) $team->is_available;
        $this->developer_ids = $team->developers->pluck('id')->toArray();
    }

    public function updateTeam()
    {
        $this->validate();

        $this->team->update([
            'name' => $this->name,
            'is_available' => $this->is_available,
        ]);

        // Prendiamo tutti gli ID degli utenti da collegare (sia PM che developers)
        $allUserIds = array_merge(
            $this->pm_id ? [$this->pm_id] : [],
            $this->developer_ids
        );

        // Sincronizziamo tutti gli utenti in una volta sola
        $this->team->pms()->sync($allUserIds);

        session()->flash('message', 'Team aggiornato con successo!');
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

        $pms = User::where('type', 'project_manager')->get()->map(function ($pm) {
            return [
                'id' => $pm->id,
                'name' => $pm->fullName(),
            ];
        });

        return view('livewire.teams.edit-team', compact('developers', 'pms'));
    }
}
