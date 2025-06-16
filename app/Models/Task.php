<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'project_id',
        'developer_id',
        'title',
        'description',
        'status',
        'priority',
        'due_date',
        'completed_at'
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'completed_at' => 'datetime'
    ];

    // Relationship with Project
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // Relationship with Developer (User)
    public function developer()
    {
        return $this->belongsTo(User::class, 'developer_id');
    }

    public function getDate($date)
    {
        if (!$date) {
            return '-';
        }
        
        return mb_convert_case(
            Carbon::parse($date)
                ->locale('it')
                ->translatedFormat('d F Y'),
            MB_CASE_TITLE,
            'UTF-8'
        );
    }

    public function getProgressPercentage()
    {
        $now = Carbon::now();
        
        // Se il task è completato, ritorna 100%
        if ($this->completed_at) {
            return 100;
        }

        // Se non c'è data di scadenza, ritorna 0%
        if (!$this->due_date) {
            return 0;
        }

        $start = Carbon::parse($this->created_at);
        $end = Carbon::parse($this->due_date);

        // Se la data odierna è prima della creazione, ritorna 0%
        if ($now->lessThan($start)) {
            return 0;
        }

        // Se la data odierna è dopo la scadenza, ritorna 100% (scaduto)
        if ($now->greaterThan($end)) {
            return 100;
        }

        // Calcola la durata totale del task in giorni
        $totalDuration = $start->diffInDays($end);
        
        // Se la durata totale è 0, gestisci il caso speciale
        if ($totalDuration === 0) {
            // Se siamo nello stesso giorno della scadenza, considera il progresso basato sulle ore
            $totalHours = $start->diffInHours($end);
            if ($totalHours === 0) {
                return 50; // Se è tutto nello stesso momento, mostra 50%
            }
            $elapsedHours = $start->diffInHours($now);
            return min(100, round(($elapsedHours / $totalHours) * 100));
        }

        // Calcola i giorni trascorsi dalla creazione
        $elapsedDays = $start->diffInDays($now);
        
        // Calcola la percentuale di progresso
        $progress = round(($elapsedDays / $totalDuration) * 100);
        
        // Assicurati che il progresso sia tra 0 e 100
        return min(100, max(0, $progress));
    }

    public function getRemainingTime()
    {
        $now = Carbon::now();
        
        // Se il task è completato, ritorna "Completata"
        if ($this->completed_at) {
            return 'Completata';
        }

        // Se non c'è data di scadenza, ritorna messaggio appropriato
        if (!$this->due_date) {
            return 'Data di scadenza non impostata';
        }

        $end = Carbon::parse($this->due_date);

        // Se la data odierna è dopo la scadenza, ritorna "Scaduta"
        if ($now->greaterThan($end)) {
            $daysOverdue = round($now->floatDiffInDays($end));
            return "Scaduta da {$daysOverdue} " . ($daysOverdue === 1 ? 'giorno' : 'giorni');
        }

        // Se manca meno di un giorno, mostra le ore rimanenti
        if ($now->diffInHours($end) < 24) {
            $hoursRemaining = round($now->floatDiffInHours($end));
            return "Mancano {$hoursRemaining} " . ($hoursRemaining === 1 ? 'ora' : 'ore');
        }

        // Altrimenti mostra i giorni rimanenti arrotondati
        $daysRemaining = round($now->floatDiffInDays($end));
        return "Mancano {$daysRemaining} " . ($daysRemaining === 1 ? 'giorno' : 'giorni');
    }
} 