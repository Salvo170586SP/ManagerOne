<?php

namespace App\Livewire\Dashboard;

use App\Models\Project;
use App\Models\Task;
use Livewire\Component;

class ChartTotalTasks extends Component
{
    public $projects;
    public $tasks;
    public $selectedProjectId = null;


    public function render()
    {
        $this->projects = Project::select('id', 'name')->get();

        if ($this->selectedProjectId) {
            $this->tasks = Task::where('project_id', $this->selectedProjectId)->get();
        } else {
            $this->tasks = collect(); // Nessuna task se nessun progetto selezionato
        }

        return view('livewire.dashboard.chart-total-tasks');
    }
}
