<?php

namespace App\Livewire\Teams;

use App\Models\Team;
use App\Models\User;
use Livewire\Component;

class IndexTeams extends Component
{
    public $search = "";

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

        $teams = $teams->with('developers','pms')->get();

        return view('livewire.teams.index-teams', compact('teams'));
    }
}
