<?php

namespace App\Jobs;

use App\Models\Project;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GenerateIdProject implements ShouldQueue
{
    use Queueable;
    public $project;
    /**
     * Create a new job instance.
     */
    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Trova l'ultimo corso basato sull'ID (o un altro campo univoco)
            $lastProject = Project::orderBy('IdProject', 'desc')->first();
            // Se non esistono corsi, inizia da 1, altrimenti incrementa l'ultimo ID trovato
            $newProjectId = $lastProject ? ((int) $lastProject->IdProject + 1) : 1;
            // Assegna il nuovo ID univoco al corso attuale e salvalo nel database
            $this->project->IdProject = $newProjectId;
            $this->project->save();
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
