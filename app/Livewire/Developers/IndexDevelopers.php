<?php

namespace App\Livewire\Developers;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class IndexDevelopers extends Component
{
    use WithPagination;

 
    public $search = "";
    public $searchDate;
    public $searchCity;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSearchCity()
    {
        $this->resetPage();
    }

    public function updatedSearchDate()
    {
        $this->resetPage();
    }

    public function getColorCategory($category)
    {
        $categoryData = collect(config('managerOne.categories'))->firstWhere('id', $category);
        $color = $categoryData['color'] ?? 'bg-gray-300';
        return $color;
    }
   
    public function getNameCategory($category)
    {
        $categoryData = collect(config('managerOne.categories'))->firstWhere('id', $category);
        $name = $categoryData['name'] ?? '-';
        return $name;
    }

    public function getColorLevel($level)
    {
        $levelData = collect(config('managerOne.levels'))->firstWhere('id', $level);
        $color = $levelData['color'] ?? 'bg-gray-300';
        return $color;
    }
  
    public function getNameLevel($level)
    {
        $levelData = collect(config('managerOne.levels'))->firstWhere('id', $level);
        $name = $levelData['name'] ?? '-';
        return $name;
    }
   
    public function getColorWorkplace($workplace)
    {
        $workplaceData = collect(config('managerOne.workplaces'))->firstWhere('id', $workplace);
        $color = $workplaceData['color'] ?? 'bg-gray-300';
        return $color;
    }
   
    public function getNameWorkplace($workplace)
    {
        $workplaceData = collect(config('managerOne.workplaces'))->firstWhere('id', $workplace);
        $name = $workplaceData['name'] ?? '-';
        return $name;
    }
   
    public function getColorType($type)
    {
        $workplaceData = collect(config('managerOne.types'))->firstWhere('id', $type);
        $color = $workplaceData['color'] ?? 'bg-gray-300';
        return $color;
    }
   
    public function getNameType($type)
    {
        $workplaceData = collect(config('managerOne.types'))->firstWhere('id', $type);
        $name = $workplaceData['name'] ?? '-';
        return $name;
    }
    
    public function deleteDev($devId)
    {
        $dev = User::findOrFail($devId);

        if ($dev) {

            if (!empty($client->img_url)) {
                if (Storage::disk('public')->exists($dev->img_url)) {
                    Storage::disk('public')->delete($dev->img_url);
                }
            }

            $dev->delete();
            
            Log::info('Developer eliminato', [
                'id' => $dev->id,
                'name' => $dev->name,
                'surname' => $dev->surname,
                'img_url' => $dev->img_url,
                'phone' => $dev->phone,
                'city' => $dev->city,
                'type' => $dev->type,
                'email' => $dev->email,
                'category' => $dev->category,
                'workplace' => $dev->workplace,
                'level' => $dev->level,
            ]);
        }
        session()->flash('message', "Developer eliminato con successo");

        return $this->redirect('/developers', navigate: true);
    }

    public function render()
    {
        $developers = User::query()
            ->where(function($query) {
                $query->where('type', 'developer')
                      ->orWhere('type', 'project_manager');
            });

        if ($this->search) {
            $developers = $developers->where(function($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('surname', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->searchCity) {
            $developers = $developers->where('city', 'like', '%' . $this->searchCity . '%');
        }

        if ($this->searchDate) {
            $developers = $developers->whereDate('created_at', '=', \Carbon\Carbon::parse($this->searchDate)->toDateString());
        }

        $developers = $developers->latest()->paginate(7);

        // Controlla se la pagina corrente supera l'ultima pagina disponibile
        if ($developers->lastPage() > 0 && $developers->currentPage() > $developers->lastPage()) {
            $this->setPage($developers->lastPage());
        } 

        // Calcola i conteggi dalla query originale (senza paginazione)
        $numberDevs = User::where('type', 'developer')->count();
        $numberPms = User::where('type', 'project_manager')->count();
        $pollCondition = User::where('type', ['developer','project_manager'])->whereNull('IdDev')->exists();

        // Ottieni la lista delle città disponibili per il filtro
        $cities = User::where(function($query) {
            $query->where('type', 'developer')
                  ->orWhere('type', 'project_manager');
        })
        ->whereNotNull('city')
        ->distinct()
        ->pluck('city')
        ->filter()
        ->values();

        return view('livewire.developers.index-developers', compact('developers', 'numberDevs', 'numberPms', 'pollCondition', 'cities'));
    }
}
