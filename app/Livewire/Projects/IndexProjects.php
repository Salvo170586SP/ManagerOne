<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Livewire\Component;

class IndexProjects extends Component
{
    public $search = "";
    public $searchDate = "";
    public $searchAvailable;

    public function deleteProject($project_id)
    {
        $project = Project::findOrFail($project_id);

        if ($project) {
            $project->delete();
        }

        return $this->redirect('/projects', navigate: true);
    }

    public function render()
    {
        $projects = Project::query();

        if ($this->search) {
            $projects = $projects->where('name', 'like', '%' . $this->search . '%');
        }

        if ($this->searchDate) {
            $projects = $projects->whereDate('created_at', '=', \Carbon\Carbon::parse($this->searchDate)->toDateString());
        }

     /*    if (!is_null($this->searchAvailable)) {
            $projects = $projects->where('is_available', $this->searchAvailable);
        }
 */
if ($this->searchAvailable !== null && $this->searchAvailable !== '') {
    $projects = $projects->where('is_available', (int) $this->searchAvailable);
}
        $projects = $projects->get();

        return view('livewire.projects.index-projects', compact('projects'));
    }
}
