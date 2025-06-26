<?php

namespace App\Livewire\Invoices;

use App\Models\Invoce;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class IndexInvoices extends Component
{
    use WithPagination;
    public $search = "";
    public $searchDate = "";
    public $searchAvailable = "";

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSearchCity()
    {
        $this->resetPage();
    }

    public function updatedSearchAvailable()
    {
        $this->resetPage();
    }

    public function deleteInvoice($invoice_id)
    {
        $invoice = Invoce::findOrFail($invoice_id);

        if ($invoice) {
            $invoice->delete();
        }

        return $this->redirect('/invoices', navigate: true);
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
        $invoices = Invoce::query();

        if ($this->search) {
            $invoices = $invoices->where('name', 'like', '%' . $this->search . '%');
        }

        if ($this->searchDate) {
            $invoices = $invoices->whereDate('created_at', '=', \Carbon\Carbon::parse($this->searchDate)->toDateString());
        }

        if ($this->searchAvailable !== null && $this->searchAvailable !== '') {
            $invoices = $invoices->where('is_available', (int) $this->searchAvailable);
        }

        $invoices = $invoices->latest()->paginate(6);

        $pollCondition =  Invoce::whereNull('IdInvoice')->exists();

        return view('livewire.invoices.index-invoices', compact('invoices', 'pollCondition'));
    }
}
