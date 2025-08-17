<?php

namespace App\Livewire\Clients\Components;

use Livewire\Component;

class TableInvoicesShow extends Component
{
    public $client;
    
    public function render()
    {
        $invoicesClient = $this->client->invoices()->paginate(3);

        return view('livewire.clients.components.table-invoices-show', compact('invoicesClient'));
    }
}
