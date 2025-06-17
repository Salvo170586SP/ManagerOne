<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GenerateIdDev implements ShouldQueue
{
    use Queueable;
    public $developer;
    /**
     * Create a new job instance.
     */
    public function __construct(User $developer)
    {
        $this->developer = $developer;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Trova l'ultimo corso basato sull'ID (o un altro campo univoco)
            $lastDeveloper = User::orderBy('IdDev', 'desc')->first();
            // Se non esistono corsi, inizia da 1, altrimenti incrementa l'ultimo ID trovato
            $newDevId = $lastDeveloper ? ((int) $lastDeveloper->IdDev + 1) : 1;
            // Assegna il nuovo ID univoco al corso attuale e salvalo nel database
            $this->developer->IdDev = $newDevId;
            $this->developer->save();
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
