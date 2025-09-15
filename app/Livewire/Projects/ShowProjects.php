<?php

namespace App\Livewire\Projects;

use App\Jobs\GenerateIdInvoces;
use App\Models\Invoce;
use App\Models\Project;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ShowProjects extends Component
{
    public $project;

    public function mount(Project $project)
    {
        $this->project = $project;
    }

    public function generateInvoicePdf()
    {
        if ($this->project->is_approved == 'approved' && $this->project->invoices->count() <= 0) {
            $invoice =  Invoce::create([
                'admin_id' => Auth::id(),
                'client_id' => $this->project->client_id,
                'project_id' => $this->project->id,
                'name' => $this->project->name . '-' . $this->project->client->fullName(),
                'client_name' => $this->project->client->fullName(),
                'preventive' => $this->project->preventive,
            ]);

            GenerateIdInvoces::dispatch($invoice);

            Log::info('Progetto modificato', [
                'user_id' => Auth::id(),
                'project_id' => $this->project->id,
                'project_name' => $this->project->name,
            ]);



            $data = [
                'invoice' => $invoice,
                'client' => $invoice->client,
                'project' => $invoice->project,
                'admin' => $invoice->admin,
                'date' => now()->format('d/m/Y'),
                'invoice_number' => 'INV-' . str_pad($invoice->id, 6, '0', STR_PAD_LEFT)
            ];

            $pdf = Pdf::loadView('livewire.invoices.pdf-invoice', $data);

            // Genera nome file
            $filename = 'fattura_' . $invoice->id . '_' . date('Y-m-d') . '.pdf';

            // Crea un file temporaneo per poter utilizzare il metodo store()
            $tempPath = sys_get_temp_dir() . '/' . $filename;
            file_put_contents($tempPath, $pdf->output());

            // Crea un UploadedFile dal file temporaneo
            $uploadedFile = new UploadedFile(
                $tempPath,
                $filename,
                'application/pdf',
                null,
                true
            );

            // Salva il file usando il metodo store() nella cartella public/invoices
            $path = $uploadedFile->store('invoices', 'public');

            // Rimuovi il file temporaneo
            unlink($tempPath);


            // Aggiorna il record della fattura con il path del PDF
            $invoice->update(['pdf_path' => $path]);

            return [
                'success' => true,
                'path' => $path,
                'filename' => $filename
            ];
        }else{
             session()->flash('message', 'Esiste già una fattura per questo progetto');
        }
    }

    public function render()
    {

        $invoices_project = Invoce::where('project_id', $this->project->id)->get();



        return view('livewire.projects.show-projects', compact('invoices_project'));
    }
}
 
