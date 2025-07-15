<?php

namespace App\Livewire\Dashboard;

use App\Models\User;
use Livewire\Component;
use Carbon\Carbon;

class ChartTotalClients extends Component
{
    public $totalClients;
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

        // Ottieni i clienti e raggruppali per mese
        $clients = User::where('type', 'client')
            ->whereBetween('created_at', [$start, $end])
            ->get();
            
        $groupedClients = [];
        foreach ($clients as $client) {
            $monthKey = Carbon::parse($client->created_at)->format('M Y');
            if (!isset($groupedClients[$monthKey])) {
                $groupedClients[$monthKey] = 0;
            }
            $groupedClients[$monthKey]++;
        }

        $total = 0;
        foreach ($labels as $month) {
            if (isset($groupedClients[$month])) {
                $total += $groupedClients[$month];
            }
            $months[$month] = $total;
        }

        $this->labels = array_values($labels);
        $this->data = array_values($months);
    }

    public function render()
    {
        $this->totalClients = (int) User::where('type', 'client')->count();
        return view('livewire.dashboard.chart-total-clients', [
            'labels' => $this->labels,
            'data' => $this->data,
        ]);
    }
}
