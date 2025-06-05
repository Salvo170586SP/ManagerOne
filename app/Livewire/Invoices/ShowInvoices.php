<?php

namespace App\Livewire\Invoices;

use App\Models\Invoce;
use Livewire\Component;

class ShowInvoices extends Component
{
    public $invoice;

    public function mount(Invoce $invoice)
    {
        $this->invoice = $invoice;
    }

    public function render()
    {
        return view('livewire.invoices.show-invoices');
    }
}
