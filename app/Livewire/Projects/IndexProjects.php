<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use App\Models\Note;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class IndexProjects extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search = "";
    public $searchDate = "";
    public $searchAvailable;
    public bool $showDrawer2 = false;
    public $selectedProjectId = null;
    public $selectedProjectNotes = [];
    public $selectedProject = null;
    public $newNoteTitle = '';
    public $newNoteDescription = '';
    public $newNoteFile = null;
    public $editNoteTitle = '';
    public $editNoteDescription = '';
    public $editNoteId = null;
    public $url_file = null;


    protected $rules = [
        'newNoteTitle' => 'required|string|max:255',
        'newNoteDescription' => 'required|string|max:500',
    ];


    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSearchDate()
    {
        $this->resetPage();
    }

    public function updatedSearchAvailable()
    {
        $this->resetPage();
    }

    public function deleteProject($project_id)
    {
        $project = Project::findOrFail($project_id);


        if ($project) {
            $project->delete();

            Log::info('Progetto eliminato', [
                'user_id' => Auth::id(),
                'project_id' => $project->id,
                'project_name' => $project->name,
            ]);
        }


        return $this->redirect('/projects', navigate: true);
    }

    public function openNotesSidebar($projectId)
    {
        $this->showDrawer2 = true;
        $this->selectedProjectId = $projectId;
        $project = Project::with('notes.admin')->find($projectId);
        $this->selectedProject = $project;
        $this->selectedProjectNotes = $project->notes;
    }

    public function closeNotesSidebar()
    {
        $this->showDrawer2 = false;
        $this->selectedProjectId = null;
        $this->selectedProjectNotes = [];
        $this->selectedProject = null;
        $this->resetEditForm();
    }

    public function addNote($project_id)
    {
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


    public function editNote($note_id)
    {
        $note = Note::findOrFail($note_id);
        $this->editNoteTitle = $note->title;
        $this->editNoteDescription = $note->description;
        $this->url_file = null; // File upload gestito separatamente
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

    public function resetEditForm()
    {
        $this->editNoteTitle = '';
        $this->editNoteDescription = '';
        $this->url_file = null;
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

    public function cancelEdit()
    {
        $this->editNoteId = null;
        $this->resetEditForm();
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

        if ($this->searchAvailable !== null && $this->searchAvailable !== '') {
            $projects = $projects->where('is_available', (int) $this->searchAvailable);
        }

        $projects = $projects->latest()->paginate(10);

        $pollCondition = Project::whereNull('IdProject')->exists();

        return view('livewire.projects.index-projects', [
            'projects' => $projects,
            'pollCondition' => $pollCondition,
        ]);
    }
}
