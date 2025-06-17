<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GenerateIdClient implements ShouldQueue
{
    use Queueable;
    public $client;
    /**
     * Create a new job instance.
     */
    public function __construct(User $client)
    {
        $this->client = $client;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Trova l'ultimo corso basato sull'ID (o un altro campo univoco)
            $lastClient = User::orderBy('IdClient', 'desc')->first();
            // Se non esistono corsi, inizia da 1, altrimenti incrementa l'ultimo ID trovato
            $newClientId = $lastClient ? ((int) $lastClient->IdClient + 1) : 1;
            // Assegna il nuovo ID univoco al corso attuale e salvalo nel database
            $this->client->IdClient = $newClientId;
            $this->client->save();
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
