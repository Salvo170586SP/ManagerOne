<?php

namespace App\Livewire\Dashboard;

use App\Models\Invoce;
use Livewire\Component;

class ChartInvoices extends Component
{
    public $totalInvoices;
    public $InvoicesPay;
    public $InvoicesNotPay;
    public $hasInvoices;

    public function mount()
    {
         $this->totalInvoices = Invoce::count();
         $this->InvoicesPay = Invoce::where('is_available', 1)->count();
         $this->InvoicesNotPay = Invoce::where('is_available', 0)->count();
         $this->hasInvoices =  ($this->InvoicesPay + $this->InvoicesNotPay) > 0;
    }
   
    public function render()
    {
        return view('livewire.dashboard.chart-invoices');
    }
}
