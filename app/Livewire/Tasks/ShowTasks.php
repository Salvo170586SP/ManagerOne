<?php

namespace App\Livewire\Tasks;

use App\Models\Note;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ShowTasks extends Component
{
    use WithFileUploads, WithPagination;

    public $project;
    public $selectedTaskNotes = [];
    public $selectedTask = [];
    public $editNoteId = null;
    public bool $showDrawer2 = false;
    public $selectedTaskId = null;
    public $newNoteTitle = '';
    public $newNoteDescription = '';
    public $newNoteFile = null;
    public $editNoteTitle = '';
    public $editNoteDescription = '';
    public $url_file = null;

    public function mount(Project $project)
    {
        $this->project = $project;
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

    public function deleteTask($taskId)
    {
        $task = Task::findOrFail($taskId);
        if ($task) {
            $task->delete();
        }

        $projectId = $this->project->id;

        $this->redirect("/tasks/$projectId/show", navigate: true);
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
    }

    public function deleteNote($taskId, $note_id)
    {
        // Trova il progetto
        $note = Note::findOrFail($note_id);

        if ($note) {
            $note->delete();
        }

        // Aggiorna la lista delle note
        $task = Task::findOrFail($taskId);
        $this->selectedTaskNotes = $task->fresh()->notes;
    }

    public function toggleImportant($note_id)
    {
        $note = Note::findOrFail($note_id);
        $note->is_true = !$note->is_true;
        $note->save();

        // Aggiorna la lista delle note per riflettere subito il cambiamento
        if ($this->selectedTaskId) {
            $task = Task::findOrFail($this->selectedTaskId);
            $this->selectedTaskNotes = $task->fresh()->notes;
        }
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
        $task = Task::findOrFail($this->selectedTaskId);
        $this->selectedTaskNotes = $task->fresh()->notes;
        $this->editNoteId = null;
    }

    public function editNote($note_id)
    {
        $note = Note::findOrFail($note_id);
        $this->editNoteTitle = $note->title;
        $this->editNoteDescription = $note->description;
        $this->url_file = null; // File upload gestito separatamente
    }

    public function toggleEditNote($noteId)
    {
        if ($this->editNoteId === $noteId) {
            $this->editNoteId = null;
            $this->resetEditForm();
        } else {
            $this->editNoteId = $noteId;
            $this->editNote($noteId);
        }
    }

    public function closeNotesSidebar()
    {
        $this->showDrawer2 = false;
        $this->selectedTaskId = null;
        $this->selectedTaskNotes = [];
        $this->selectedTask = null;
        $this->resetEditForm();
    }

    public function resetEditForm()
    {
        $this->editNoteTitle = '';
        $this->editNoteDescription = '';
        $this->url_file = null;
    }

    public function addNote($taskId)
    {
        // Validazione
        $this->validate([
            'newNoteTitle' => 'required|string|max:255',
            'newNoteDescription' => 'required|string|max:500',
        ]);

        $task = Task::findOrFail($taskId);

        $url = null;

        if ($this->url_file) {
            $url = $this->url_file->store('filesNote', 'public');
        }

        // Salva la nota
        $note = new Note();
        $note->admin_id = Auth::id();
        $note->task_id = $task->id;
        $note->title = $this->newNoteTitle;
        $note->description = $this->newNoteDescription;
        $note->url_file = $url;
        $note->save();


        // Aggiorna la lista delle note
        $this->selectedTaskNotes = $task->fresh()->notes;

        $this->reset(['newNoteTitle', 'newNoteDescription']);
    }

    public function openNotesSidebar($taskId)
    {
        $this->showDrawer2 = true;

        $this->selectedTaskId = $taskId;
        $task = Task::findOrFail($taskId);
        $this->selectedTask = $task;
        $this->selectedTaskNotes = $task->notes;
    }

    public function getStateName($state)
    {
        $projectData = collect(config('managerOne.states_project'))->firstWhere('id', $state);
        return $projectData['name'] ?? $state;
    }

    public function getStateColor($state)
    {
        $projectData = collect(config('managerOne.states_project'))->firstWhere('id', $state);
        return $projectData['color'] ?? 'bg-gray-300';
    }

    public function getPriorityName($priority)
    {
        $taskData = collect(config('managerOne.priorities_task'))->firstWhere('id', $priority);
        return $taskData['name'] ?? $priority;
    }

    public function getPriorityColor($priority)
    {
        $taskData = collect(config('managerOne.priorities_task'))->firstWhere('id', $priority);
        return $taskData['color'] ?? 'bg-gray-300';
    }

    public function getStatusName($priority)
    {
        $taskData = collect(config('managerOne.states_task'))->firstWhere('id', $priority);
        return $taskData['name'] ?? $priority;
    }

    public function getStatusColor($priority)
    {
        $taskData = collect(config('managerOne.states_task'))->firstWhere('id', $priority);
        return $taskData['color'] ?? 'bg-gray-300';
    }

    public function render()
    {
        $user = Auth::user();

        if ($user instanceof User && $user->hasRole('admin')) {
            $tasks = $this->project->tasks()->latest()->paginate(8);
        } else if ($user instanceof User && $user->hasRole('developer')) {
            $tasks = $this->project->tasks()
                ->where('developer_id', $user->id)
                ->latest()
                ->paginate(8);
        } else if ($user instanceof User && $user->hasRole('project_manager')) {
            if ($this->project->team && $this->project->team->users->contains($user)) {
                $tasks = $this->project->tasks()->latest()->paginate(8);
            } else {
                $tasks = Task::where('id', '<', 0)->paginate(8);
            }
        }

        return view('livewire.tasks.show-tasks', [
            'tasks' => $tasks,
            'project' => $this->project,
        ]);
    }
}
