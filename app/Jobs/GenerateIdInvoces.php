<?php

namespace App\Jobs;

use App\Models\Invoce;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GenerateIdInvoces implements ShouldQueue
{
    use Queueable;
    public $invoice;
    /**
     * Create a new job instance.
     */
    public function __construct(Invoce $invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Trova l'ultimo corso basato sull'ID (o un altro campo univoco)
            $lastInvoice = Invoce::orderBy('IdInvoice', 'desc')->first();
            // Se non esistono corsi, inizia da 1, altrimenti incrementa l'ultimo ID trovato
            $newInvoiceId = $lastInvoice ? ((int) $lastInvoice->IdInvoice + 1) : 1;
            // Assegna il nuovo ID univoco al corso attuale e salvalo nel database
            $this->invoice->IdInvoice = $newInvoiceId;
            $this->invoice->save();
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
