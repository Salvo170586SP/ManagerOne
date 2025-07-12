<?php

namespace App\Livewire\Documents;

use App\Models\Invoce;
use App\Models\Message;
use App\Models\Note;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class ShowDocument extends Component
{
    public $user;
    use WithPagination;

    public $search = "";
    public $searchDate;

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSearchDate()
    {
        $this->resetPage();
    }

    public function downloadInvoicePdf($invoiceId)
    {
        try {
            $invoice = Invoce::findOrFail($invoiceId);
            $filePath = $invoice->pdf_path;

            // Verifica se il file esiste
            if (!Storage::disk('public')->exists($filePath)) {
                session()->flash('error', 'File non trovato.');
                return;
            }

            // Ottieni il path completo del file
            $fullPath = Storage::disk('public')->path($filePath);

            // Restituisci il file come download
            return response()->download($fullPath);
        } catch (\Exception $e) {
            session()->flash('error', 'Errore durante il download: ' . $e->getMessage());
            return;
        }
    }

    public function downloadChatAttachment($messageId)
    {
        try {
            $message = Message::findOrFail($messageId);
            $filePath = $message->attachment_path;

            // Verifica se il file esiste
            if (!Storage::disk('public')->exists($filePath)) {
                session()->flash('error', 'File non trovato.');
                return;
            }

            // Ottieni il path completo del file
            $fullPath = Storage::disk('public')->path($filePath);

            // Restituisci il file come download
            return response()->download($fullPath);
        } catch (\Exception $e) {
            session()->flash('error', 'Errore durante il download: ' . $e->getMessage());
            return;
        }
    }

    public function render()
    {
        $invoicesQuery = $this->user->invoices();

        if ($this->search) {
            $invoicesQuery = $invoicesQuery->where('name', 'like', '%' . $this->search . '%');
        }

        if ($this->searchDate) {
            $invoicesQuery = $invoicesQuery->whereDate('created_at', '=', \Carbon\Carbon::parse($this->searchDate)->toDateString());
        }

        $invoices = $invoicesQuery->latest()->paginate(12);

        $projectNotes = Note::whereIn('project_id', $this->user->projects()->pluck('id')->toArray())
            ->whereNotNull('url_file');
        $taskNotes = Note::whereIn('task_id', $this->user->tasks()->pluck('id')->toArray())
            ->whereNotNull('url_file');

        if ($this->search) {
            $projectNotes = $projectNotes->where('title', 'like', '%' . $this->search . '%');
            $taskNotes = $taskNotes->where('title', 'like', '%' . $this->search . '%');
        }

        if ($this->searchDate) {
            $projectNotes = $projectNotes->whereDate('created_at', '=', \Carbon\Carbon::parse($this->searchDate)->toDateString());
            $taskNotes = $taskNotes->whereDate('created_at', '=', \Carbon\Carbon::parse($this->searchDate)->toDateString());
        }

        $notesWithAttachments = $projectNotes->union($taskNotes)
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        $chatAttachments = collect();
        if (in_array($this->user->type, ['developer', 'project_manager'])) {
            $chatAttachmentsQuery = Message::where(function ($query) {
                $query->where('sender_id', $this->user->id)
                    ->orWhere('receiver_id', $this->user->id);
            })
                ->whereNotNull('attachment_path')
                ->with(['sender', 'receiver']);

            if ($this->search) {
                $chatAttachmentsQuery = $chatAttachmentsQuery->where('attachment_path', 'like', '%' . $this->search . '%');
            }

            if ($this->searchDate) {
                $chatAttachmentsQuery = $chatAttachmentsQuery->whereDate('created_at', '=', \Carbon\Carbon::parse($this->searchDate)->toDateString());
            }

            $chatAttachments = $chatAttachmentsQuery
                ->orderBy('created_at', 'desc')
                ->paginate(5);
        }

        return view('livewire.documents.show-document', [
            'invoices' => $invoices,
            'notesWithAttachments' => $notesWithAttachments,
            'chatAttachments' => $chatAttachments,
        ]);
    }
}
