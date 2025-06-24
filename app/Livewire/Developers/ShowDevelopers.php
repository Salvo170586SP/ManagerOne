<?php

namespace App\Livewire\Developers;

use App\Models\Note;
use App\Models\User;
use App\Models\Task;
use Livewire\Component;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class ShowDevelopers extends Component
{
    use WithFileUploads;

    public $developer;
    public Collection $taskDates;
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

    public function mount(User $developer)
    {
        $this->developer = $developer;
        $this->taskDates = collect();
        
        // Initialize taskDates with current completed_at values
        foreach ($developer->tasks as $task) {
            $this->taskDates[$task->id] = $task->completed_at ? $task->completed_at->format('Y-m-d') : '';
        }
    }
   
    public function updatedTaskDates($value, $key)
    {
        $task = Task::find($key);
        
        if ($task) {
            $completed_at = $value ? \Carbon\Carbon::parse($value)->startOfDay() : null;

            $task->update([
                'completed_at' => $completed_at
            ]);
        }
    }

    public function getColorType($type)
    {
        $typesData = collect(config('managerOne.types'))->firstWhere('id', $type);
        $color = $typesData['color'] ?? 'bg-gray-300';
        return $color;
    }

    public function getNameType($type)
    {
        $typesData = collect(config('managerOne.types'))->firstWhere('id', $type);
        $name = $typesData['name'] ?? '-';
        return $name;
    }

    public function getColorCategory($category)
    {
        $categoryData = collect(config('managerOne.categories'))->firstWhere('id', $category);
        $color = $categoryData['color'] ?? 'bg-gray-300';
        return $color;
    }
   
    public function getNameCategory($category)
    {
        $categoryData = collect(config('managerOne.categories'))->firstWhere('id', $category);
        $name = $categoryData['name'] ?? '-';
        return $name;
    }

    public function getColorLevel($level)
    {
        $levelData = collect(config('managerOne.levels'))->firstWhere('id', $level);
        $color = $levelData['color'] ?? 'bg-gray-300';
        return $color;
    }
  
    public function getNameLevel($level)
    {
        $levelData = collect(config('managerOne.levels'))->firstWhere('id', $level);
        $name = $levelData['name'] ?? '-';
        return $name;
    }
   
    public function getColorWorkplace($workplace)
    {
        $workplaceData = collect(config('managerOne.workplaces'))->firstWhere('id', $workplace);
        $color = $workplaceData['color'] ?? 'bg-gray-300';
        return $color;
    }
   
    public function getNameWorkplace($workplace)
    {
        $workplaceData = collect(config('managerOne.workplaces'))->firstWhere('id', $workplace);
        $name = $workplaceData['name'] ?? '-';
        return $name;
    }

    public function getPriorityName($priority)
    {
        $taskData = collect(config('managerOne.priorities_task'))->first(function ($item) use ($priority) {
            return $item['id'] === $priority || $item['name'] === $priority;
        });
        return $taskData['name'] ?? $priority;
    }

    public function getColorPriorityTask($task)
    {
        $priorityId = is_string($task) ? $task : $task->priority;
        $taskData = collect(config('managerOne.priorities_task'))->first(function ($item) use ($priorityId) {
            return $item['id'] === $priorityId || $item['name'] === $priorityId;
        });

        return $taskData['color'] ?? 'bg-gray-300';
    }
   
    public function getStatusNameTask($priority)
    {
        $taskData = collect(config('managerOne.states_task'))->first(function ($item) use ($priority) {
            return $item['id'] === $priority;
        });
        return $taskData['name'] ?? $priority;
    }

    public function getColorStatusTask($task)
    {
        $priorityId = is_string($task) ? $task : $task->priority;
        $taskData = collect(config('managerOne.states_task'))->first(function ($item) use ($priorityId) {
            return $item['id'] === $priorityId;
        });

        return $taskData['color'] ?? 'bg-gray-300';
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

    public function render()
    {
        return view('livewire.developers.show-developers');
    }
}
