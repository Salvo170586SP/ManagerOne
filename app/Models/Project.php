<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'IdProject',
        'client_id',
        'name',
        'description',
        'preventive',
        'is_approved',
        'team_id',
        'state',
        'end_date',
    ];

    protected $attributes = [
        'preventive' => 0.00,
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoce::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function createDate()
    {
        return mb_convert_case(
            Carbon::parse($this->created_at)
                ->locale('it')
                ->translatedFormat('d F Y'),
            MB_CASE_TITLE,
            'UTF-8'
        );
    }

    public function getProgressPercentage()
    {
        if ($this->is_approved !== 'approved' || !$this->end_date) {
            return 0;
        }

        // NOTA: Viene utilizzata la data di creazione della prima fattura come data di inizio del progetto.
        // Una soluzione più robusta sarebbe aggiungere un campo `approved_at` alla tabella `projects`.
        $firstInvoice = $this->invoices()->orderBy('created_at', 'asc')->first();

        if (!$firstInvoice) {
            // Se il progetto è approvato ma non ha fatture, non è possibile determinare la data di inizio. Ritorno 0.
            return 0;
        }

        $now = Carbon::now();
        $start = $firstInvoice->created_at;
        $end = Carbon::parse($this->end_date);

        // Se la data di fine è passata, ritorna 100%
        if ($now->greaterThan($end)) {
            return 100;
        }

        // Se la data attuale è prima della data di inizio (approvazione), ritorna 0%
        if ($now->lessThan($start)) {
            return 0;
        }

        // Calcola i giorni totali del progetto dall'approvazione
        $totalDays = $start->diffInDays($end);
        
        if ($totalDays <= 0) {
            return 100;
        }

        // Calcola i giorni trascorsi dall'inizio (approvazione)
        $elapsedDays = $start->diffInDays($now);

        // Calcola la percentuale di progresso
        $progress = ($elapsedDays / $totalDays) * 100;

        // Assicurati che il progresso sia tra 0 e 100
        return max(0, min(100, round($progress)));
    }

    public function getRemainingTime()
    {
        if ($this->is_approved !== 'approved') {
            return 'In attesa di approvazione';
        }

        if (!$this->end_date) {
            return 'Data di fine non impostata';
        }

        $now = Carbon::now();
        $end = Carbon::parse($this->end_date);

        if ($now->greaterThan($end)) {
            return 'Completato, in consegna';
        }

        $remaining = $now->diffForHumans($end, [
            'parts' => 2,
            'syntax' => true,
            'short' => true,
            'options' => Carbon::JUST_NOW | Carbon::ONE_DAY_WORDS,
            'aUnit' => true,
        ]);

        return $remaining;
    }

    public function getEndDate()
    {
        if (!$this->end_date) {
            return '-';
        }

        return mb_convert_case(
            Carbon::parse($this->end_date)
                ->locale('it')
                ->translatedFormat('d F Y'),
            MB_CASE_TITLE,
            'UTF-8'
        );
    }
}