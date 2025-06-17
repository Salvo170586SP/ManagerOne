<?php

namespace App\Livewire\Teams;

use App\Models\Team;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class IndexTeams extends Component
{
    use WithPagination;
    
    public $search = "";

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function deleteTeam($team_id)
    {
        $team = Team::findOrFail($team_id);

        if ($team) {
            $team->developers()->detach();
            $team->delete();
        }

        return $this->redirect('/teams', navigate: true);
    }

    public function deleteMember($member_id)
    {
        $member = User::findOrFail($member_id);

        if ($member) {
            $member->teams()->detach();
        }

        return $this->redirect('/teams', navigate: true);
    }

    public function render()
    {
        $teams = Team::query();

        if ($this->search) {
            $teams = $teams->where('name', 'like', '%' . $this->search . '%');
        }

        $teams = $teams->with('developers','pms')->latest()->paginate(6);

        return view('livewire.teams.index-teams', compact('teams'));
    }
}
