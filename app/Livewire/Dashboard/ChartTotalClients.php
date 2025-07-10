<?php

namespace App\Livewire\Dashboard;

use App\Models\User;
use Livewire\Component;
use Carbon\Carbon;

class ChartTotalClients extends Component
{
    public $clients;
    public $hasClients;
    public $clientsThisYear;
    public $labels;
    public $data;
 
    public function mount()
    {
        $start = Carbon::create(2025, 1, 1);
        $end = Carbon::now();

        $months = [];
        $labels = [];
        $current = $start->copy();

        while ($current <= $end) {
            $monthLabel = $current->format('M Y');
            $labels[] = $monthLabel;
            $months[$monthLabel] = 0;
            $current->addMonth();
        }

        $clients = User::where('type', 'client')
            ->whereBetween('created_at', [$start, $end])
            ->get()
            ->groupBy(function($item) {
                return Carbon::parse($item->created_at)->format('M Y');
            });

        $total = 0;
        foreach ($labels as $month) {
            if (isset($clients[$month])) {
                $total += $clients[$month]->count();
            }
            $months[$month] = $total;
        }

        $this->labels = array_values($labels);
        $this->data = array_values($months);
    }

    public function render()
    {
        return view('livewire.dashboard.chart-total-clients', [
            'labels' => $this->labels,
            'data' => $this->data,
        ]);
    }
}
