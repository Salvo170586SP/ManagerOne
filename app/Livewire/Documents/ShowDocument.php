<?php

namespace App\Livewire\Documents;

use App\Models\Invoce;
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

        // Recupera tutte le note con allegato dell'utente (come client e come developer)
        $projectNotes = \App\Models\Note::whereIn('project_id', $this->user->projects()->pluck('id')->toArray())
            ->whereNotNull('url_file')
            ->get();
        $taskNotes = \App\Models\Note::whereIn('task_id', $this->user->tasks()->pluck('id')->toArray())
            ->whereNotNull('url_file')
            ->get();
        $notesWithAttachments = $projectNotes->merge($taskNotes);

        return view('livewire.documents.show-document', [
            'invoices' => $invoices,
            'notesWithAttachments' => $notesWithAttachments,
        ]);
    }
}
