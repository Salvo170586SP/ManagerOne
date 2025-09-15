<?php

namespace App\Livewire\Projects;

use App\Jobs\GenerateIdInvoces;
use App\Models\Invoce;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class EditProjects extends Component
{
    public $project;
    public $client_id;
    public $name;
    public $description;
    public $preventive;
    public $end_date;
    public $is_approved;

    protected $rules = [
        'name' => 'required',
        'description' => 'nullable',
        'end_date' => 'required|date|after:now',
        'preventive' => 'required|numeric|min:0|max:999999.99',
    ];

    protected $messages = [
        'name.required' => 'Il campo è obbligatorio',
        'preventive.required' => 'Il campo è obbligatorio',
        'preventive.numeric' => 'Il campo accetta solo numeri',
        'preventive.min' => 'Il campo deve avere almeno un numero',
        'preventive.max' => 'Il campo deve avere massimo 999999.99',
        'end_date.required' => 'Il campo è obbligatorio',
        'end_date.date' => 'Il campo deve essere una data',
        'end_date.after' => 'Il campo deve avere minimo la data odierna',
    ];

    public function mount(Project $project)
    {
        $this->project = $project;
        $this->client_id = $project->client_id;
        $this->name = $project->name;
        $this->description = $project->description;
        $this->preventive = $project->preventive;
        $this->end_date = $project->end_date;
        $this->is_approved =  $project->is_approved;
    }

    public function editProject()
    {
        $this->validate();

        $this->project->update([
            'name' => $this->name,
            'description' => $this->description,
            'end_date' => $this->end_date,
            'preventive' => $this->preventive ?? 0.00,
            'is_approved' => $this->is_approved,
        ]);

        if ($this->project->is_approved == 'approved') {
            if ($this->project->invoices->count() < 1) {
                $invoice =  Invoce::create([
                    'admin_id' => Auth::id(),
                    'client_id' => $this->project->client_id,
                    'project_id' => $this->project->id,
                    'name' => $this->project->name . '-' . $this->project->client->fullName(),
                    'client_name' => $this->project->client->fullName(),
                    'preventive' => $this->project->preventive,
                ]);

                GenerateIdInvoces::dispatch($invoice);


                $this->generateInvoicePdf($invoice->id);

                Log::info('Progetto modificato', [
                    'user_id' => Auth::id(),
                    'project_id' => $this->project->id,
                    'project_name' => $this->project->name,
                ]);
            }
        }

        Log::info('Progetto modificato', [
            'user_id' => Auth::id(),
            'project_id' => $this->project->id,
            'project_name' => $this->project->name,
        ]);

        session()->flash('message', 'Progetto modificato con successo');

        $this->reset();

        $this->redirect('/projects', navigate: true);
    }

    public function generateInvoicePdf($invoiceId)
    {
        $invoice = Invoce::with(['client', 'project'])->findOrFail($invoiceId);

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
    }

    public function render()
    {
        $typesApproved = config('managerOne.approved_types_project');
        return view('livewire.projects.edit-projects', compact('typesApproved'));
    }
}
