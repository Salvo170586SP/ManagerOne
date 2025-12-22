<?php

namespace App\Livewire\Projects;

use App\Jobs\GenerateIdInvoces;
use App\Jobs\GenerateIdProject;
use App\Models\Invoce;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class CreateProject extends Component
{
    public $client_id;
    public $name;
    public $description;
    public $preventive;
    public $end_date;

    protected $rules = [
        'client_id' => 'required',
        'name' => 'required',
        'description' => 'nullable',
        'preventive' => 'required|numeric|min:0|max:999999.99',
        'end_date' => 'required|date|after:now',
    ];

    protected $messages = [
        'client_id.required' => 'Il campo è obbligatorio',
        'name.required' => 'Il campo è obbligatorio',
        'preventive.required' => 'Il campo è obbligatorio',
        'preventive.numeric' => 'Il campo accetta solo numeri',
        'preventive.min' => 'Il campo deve avere almeno un numero',
        'preventive.max' => 'Il campo deve avere massimo 999999.99',
        'end_date.required' => 'Il campo è obbligatorio',
        'end_date.date' => 'Il campo deve essere una data',
        'end_date.after' => 'Il campo deve avere minimo la data odierna',
    ];

    public function submit()
    {
        $this->validate();

        $project = Project::create([
            'client_id' => $this->client_id,
            'name' => $this->name,
            'description' => $this->description,
            'preventive' => $this->preventive ?? 0.00,
            'end_date' => $this->end_date,
        ]);

        Log::info('Progetto creato', [
            'user_id' => Auth::id(),
            'project_id' => $project->id,
            'project_name' => $project->name,
        ]);

        GenerateIdProject::dispatch($project);

        $this->reset();

        session()->flash('message', 'Progetto creato con successo');

        return  $this->redirect('/projects', navigate: true);
    }

    public function generateInvoicePdf($invoiceId)
    {
        $invoice = Invoce::with(['client', 'project', 'admin'])->findOrFail($invoiceId);

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
        $clients = User::where('type', 'client')->get()->map(function ($client) {
            return [
                'id' => $client->id,
                'name' => $client->fullName(),
            ];
        });

        return view('livewire.projects.create-project', compact('clients'));
    }
}
