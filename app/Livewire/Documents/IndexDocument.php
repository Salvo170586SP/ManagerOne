<?php

namespace App\Livewire\Documents;


use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class IndexDocument extends Component
{
    use WithPagination;
    
    public $search = "";
    public $searchDate;
    public $searchType;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSearchDate()
    {
        $this->resetPage();
    }

    public function render()
    {
        $clients = User::query();

        if ($this->search) {
            $clients = $clients->where('name', 'like', '%' . $this->search . '%');
        }

        if ($this->searchDate) {
            $clients = $clients->whereDate('created_at', '=', \Carbon\Carbon::parse($this->searchDate)->toDateString());
        }
     
        if ($this->searchType) {
            $clients = $clients->where('type', 'like', '%' . $this->searchType . '%');
        }

        $clients = $clients->where('type', 'client')->latest()->paginate(10);

     
       
        $developers = User::query();

        if ($this->search) {
            $developers = $developers->where('name', 'like', '%' . $this->search . '%');
        }

        if ($this->searchDate) {
            $developers = $developers->whereDate('created_at', '=', \Carbon\Carbon::parse($this->searchDate)->toDateString());
        }

        if ($this->searchType) {
            $developers = $developers->where('type', 'like', '%' . $this->searchType . '%');
        }

        $developers = $developers->where('type', 'developer')->latest()->paginate(10);
      
      


        $pms = User::query();

        if ($this->search) {
            $pms = $pms->where('name', 'like', '%' . $this->search . '%');
        }

        if ($this->searchDate) {
            $pms = $pms->whereDate('created_at', '=', \Carbon\Carbon::parse($this->searchDate)->toDateString());
        }

        if ($this->searchType) {
            $pms = $pms->where('type', 'like', '%' . $this->searchType . '%');
        }

        $pms = $pms->where('type', 'project_manager')->latest()->paginate(10);

        return view('livewire.documents.index-document', compact('clients', 'developers', 'pms'));
    }
}
