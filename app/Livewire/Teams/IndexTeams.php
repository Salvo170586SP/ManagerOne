<?php

namespace App\Livewire\Teams;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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

            Log::info('Team eliminato', [
                'id' => $team->id,
                'name' => $team->name
            ]);
        }

        return $this->redirect('/teams', navigate: true);
    }

    public function deleteMember($member_id)
    {
        $member = User::findOrFail($member_id);

        if ($member) {
            $member->teams()->detach();

            Log::info('Team - eliminato membro del team', [
                'member_id' => $member->id,
                'member_name' => $member->name,
            ]);
        }

        return $this->redirect('/teams', navigate: true);
    }

    public function render()
    {
        $user = Auth::user();

        if ($user->hasRole('developer')) {
            $teams = $user->teams();
        } else {
            $teams = Team::query();
        }

        if ($this->search) {
            $teams = $teams->where('name', 'like', '%' . $this->search . '%');
        }

        $teams = $teams->with('developers', 'pms')->latest()->paginate(6);

        return view('livewire.teams.index-teams', compact('teams'));
    }
}
