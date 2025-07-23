<?php

namespace App\Livewire\Projects;

use App\Models\Note;
use App\Models\Project;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ApprovedProjects extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search = "";
    public $searchDate = "";
    public $teamSelections = [];
    public $stateSelections = [];
    public $selectedProjectNotes = [];
    public $selectedProject = null;
    public $editNoteId = null;
    public bool $showDrawer2 = false;
    public $selectedProjectId = null;
    public $newNoteTitle = '';
    public $newNoteDescription = '';
    public $newNoteFile = null;
    public $editNoteTitle = '';
    public $editNoteDescription = '';
    public $url_file = null;

    protected $rules = [
        'newNoteTitle' => 'required|string|max:255',
        'newNoteDescription' => 'required|string|max:500',
    ];


    public function downloadFile($note_id)
    {
        $note = Note::findOrFail($note_id);
        $filePath = $note->url_file;

        if (!$filePath || !Storage::disk('public')->exists($filePath)) {
            session()->flash('error', 'File non trovato.');
            return;
        }

        $fullPath = Storage::disk('public')->path($filePath);
        return response()->download($fullPath);
    }

    public function deleteFile($note_id)
    {
        $note = Note::findOrFail($note_id);
        $url = $note->url_file;
        if ($url) {
            Storage::disk('public')->delete($note->url_file);
            $url = null;
            $note->url_file = $url;
            $note->save();
        }
        // Aggiorna la lista delle note per il frontend
        if ($this->selectedProjectId) {
            $project = Project::findOrFail($this->selectedProjectId);
            $this->selectedProjectNotes = $project->fresh()->notes;
        }
    }

    public function addNote($project_id)
    {
        // Validazione
        $this->validate();

        // Trova il progetto
        $project = Project::findOrFail($project_id);

        $url = null;

        if ($this->url_file) {
            $url = $this->url_file->store('filesNote', 'public');
        }

        // Salva la nota
        $note = new Note();
        $note->admin_id = Auth::id();
        $note->project_id = $project->id;
        $note->title = $this->newNoteTitle;
        $note->description = $this->newNoteDescription;
        $note->url_file = $url;
        $note->save();


        // Aggiorna la lista delle note
        $this->selectedProjectNotes = $project->fresh()->notes;

        $this->reset(['newNoteTitle', 'newNoteDescription', 'url_file']);

        // Emitti l'evento solo se tutto è andato bene
        $this->dispatch('noteAdded');
    }

    public function deleteNote($project_id, $note_id)
    {
        // Trova il progetto
        $note = Note::findOrFail($note_id);

        if ($note) {
            $note->delete();
        }

        // Aggiorna la lista delle note
        $project = Project::findOrFail($project_id);
        $this->selectedProjectNotes = $project->fresh()->notes;
    }

    public function toggleImportant($note_id)
    {
        $note = Note::findOrFail($note_id);
        $note->is_true = !$note->is_true;
        $note->save();

        // Aggiorna la lista delle note per riflettere subito il cambiamento
        if ($this->selectedProjectId) {
            $project = Project::findOrFail($this->selectedProjectId);
            $this->selectedProjectNotes = $project->fresh()->notes;
        }
    }
    public function closeNotesSidebar()
    {
        $this->showDrawer2 = false;
        $this->selectedProjectId = null;
        $this->selectedProjectNotes = [];
        $this->selectedProject = null;
        $this->resetEditForm();
    }

    public function resetEditForm()
    {
        $this->editNoteTitle = '';
        $this->editNoteDescription = '';
        $this->url_file = null;
    }


    public function updateNote($note_id)
    {
        // Validazione
        $this->validate([
            'editNoteTitle' => 'required|string|max:255',
            'editNoteDescription' => 'required|string|max:500',
        ]);

        $note = Note::findOrFail($note_id);

        // Gestione dell'immagine
        $url = $note->url_file;  // MantieneF l'URL esistente come default

        // Se è stata caricata una nuova immagine
        if ($this->url_file && !is_string($this->url_file)) {
            // Se esiste già un'immagine, la eliminiamo
            if ($note->url_file) {
                Storage::disk('public')->delete($note->url_file);
            }
            // Salva la nuova immagine
            $url = $this->url_file->store('filesNote', 'public');
        }

        $note->title = $this->editNoteTitle;
        $note->description = $this->editNoteDescription;
        $note->url_file = $url;
        $note->save();

        // Aggiorna la lista delle note
        $project = Project::findOrFail($this->selectedProjectId);
        $this->selectedProjectNotes = $project->fresh()->notes;
        $this->editNoteId = null;
    }

    public function toggleEditNote($note_id)
    {
        if ($this->editNoteId === $note_id) {
            $this->editNoteId = null;
            $this->resetEditForm();
        } else {
            $this->editNoteId = $note_id;
            $this->editNote($note_id);
        }
    }

    public function editNote($note_id)
    {
        $note = Note::findOrFail($note_id);
        $this->editNoteTitle = $note->title;
        $this->editNoteDescription = $note->description;
        $this->url_file = null; // File upload gestito separatamente
    }


    public function openNotesSidebar($projectId)
    {
        $this->showDrawer2 = true;
        $this->selectedProjectId = $projectId;
        $project = Project::with('notes.admin')->find($projectId);
        $this->selectedProject = $project;
        $this->selectedProjectNotes = $project->notes;
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSearchDate()
    {
        $this->resetPage();
    }


    public function updatedTeamSelections($team_id, $project_id)
    {
        $projectId = explode('-', $project_id)[1];

        $project = Project::findOrFail($projectId);
        // Se il valore è vuoto o nullo, rimuovi il team
        $project->team_id = $team_id ?: null;
        $project->save();

        // Aggiorna la disponibilità del team solo se esiste un team selezionato
        if ($team_id) {
            $team = Team::findOrFail($team_id);
            $team->is_available = true;
            $team->save();
        }

        session()->flash('message', "Assegnazione del progetto $project->name aggiornata con successo");
    }

    public function updatedStateSelections($state, $project_id)
    {
        $projectId = explode('-', $project_id)[1];

        $project = Project::findOrFail($projectId);
        $project->state = $state;
        $project->save();

        session()->flash('message', "Stato del progetto aggiornato con successo");
    }

    public function render()
    {
        $user = Auth::user();
        $query = Project::where('is_approved', 'approved');

        if ($user->hasRole('developer')) {
            $developerTeamIds = $user->teams()->pluck('teams.id')->toArray();
            $query->whereIn('team_id', $developerTeamIds);
        }

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        if ($this->searchDate) {
            $query->whereDate('created_at', '=', \Carbon\Carbon::parse($this->searchDate)->toDateString());
        }

        $projects = $query->latest()->paginate(10);

        $teams = Team::all();
        $states_project = config('managerOne.states_project');
        $selectColors = [];

        // Initialize team selections and state colors for each project
        foreach ($projects as $project) {
            $this->teamSelections["project-{$project->id}"] = $project->team_id;
            $this->stateSelections["project-{$project->id}"] = in_array($project->state, array_column($states_project, 'id'))
                ? $project->state
                : null;

            $currentState = collect($states_project)->firstWhere('id', $this->stateSelections["project-{$project->id}"]);
            $selectColors[$project->id] = $currentState ? $currentState['color'] : 'bg-white';
        }

        return view('livewire.projects.approved-projects', compact('projects', 'teams', 'states_project', 'selectColors'));
    }
}
