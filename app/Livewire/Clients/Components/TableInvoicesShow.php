<?php

namespace App\Livewire\Clients\Components;

use Livewire\Component;
use Livewire\WithPagination;

class TableInvoicesShow extends Component
{
    use WithPagination;
    public $client;
    
    public function render()
    {
        $invoicesClient = $this->client->invoices()->paginate(3);

        return view('livewire.clients.components.table-invoices-show', compact('invoicesClient'));
    }
}
