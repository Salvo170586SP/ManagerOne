<?php

namespace App\Livewire\Invoices;

use App\Models\Invoce;
use Livewire\Component;

class EditInvoices extends Component
{

    public $invoice;
    public $name;
    public $description;
    public $is_available = false;

    protected $rules = [
        'name' => 'required',
        'description' => 'nullable',
    ];

    public function mount(Invoce $invoice)
    {
        $this->invoice = $invoice;
        $this->name = $invoice->name;
        $this->description = $invoice->description;
        $this->is_available = (bool) $invoice->is_available;
    }

    public function editInvoice()
    {
        $this->validate();

        $this->invoice->update([
            'name' => $this->name,
            'description' => $this->description,
            'is_available' => $this->is_available,
        ]);

        session()->flash('message', 'Fattura modificata con successo');

        $this->reset();

        $this->redirect('/invoices', navigate: true);
    }
    
    public function render()
    {
        return view('livewire.invoices.edit-invoices');
    }
}
