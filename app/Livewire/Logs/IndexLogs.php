<?php

namespace App\Livewire\Logs;

use Livewire\Component;
use Illuminate\Support\Facades\File;

class IndexLogs extends Component
{
    public $logs = [];
    public $search = '';
    public $searchDate;

    public function mount() {}

    public function deleteLog()
    {
        $logPath = storage_path('logs/laravel.log');

        if (File::exists($logPath)) {
            $lines = file($logPath);

            $filteredLines = array_filter($lines, function ($line) {
                return !(str_contains($line, 'Progetto ') || str_contains($line, 'Task ') || str_contains($line, 'Developer ') || str_contains($line, 'Team ') || str_contains($line, 'Evento '));
            });

            File::put($logPath, implode('', $filteredLines));

            $this->logs = [];
        }

        session()->flash('message', "Logs eliminati con successo");

        return $this->redirect('/logs', navigate: true);
    }

    public function render()
    {
        $logPath = storage_path('logs/laravel.log');
        $customLogs = [];

        if (File::exists($logPath)) {
            $lines = array_slice(file($logPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES), -1000); // prendo più righe per sicurezza
            // Filtro solo i log personalizzati
            $customLogs = array_filter($lines, function ($line) {
                return str_contains($line, 'Cliente') || str_contains($line, 'Progetto ') || str_contains($line, 'Task ') || str_contains($line, 'Developer ') || str_contains($line, 'Team ') || str_contains($line, 'Evento ');
            });
        }

        $filteredLogs = array_reverse($customLogs);

        if ($this->search) {
            $filteredLogs = array_filter($filteredLogs, function ($log) {
                return stripos($log, $this->search) !== false;
            });
        }

        if ($this->searchDate) {
            $filteredLogs = array_filter($filteredLogs, function ($log) {
                preg_match('/^\[(.*?)\]/', $log, $matches);
                if (isset($matches[1])) {
                    $logDate = \Carbon\Carbon::parse($matches[1])->format('Y-m-d');
                    return $logDate === $this->searchDate;
                }
                return false;
            });
        }

        $this->logs = $filteredLogs;

        return view('livewire.logs.index-logs');
    }
}
