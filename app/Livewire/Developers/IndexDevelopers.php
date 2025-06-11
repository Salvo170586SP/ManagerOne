<?php

namespace App\Livewire\Developers;

use App\Models\User;
use Livewire\Component;

class IndexDevelopers extends Component
{
    public $search = "";
    public $searchDate;
    public $searchCity;

    public function getColorCategory($category)
    {
        $categoryData = collect(config('managerOne.categories'))->firstWhere('name', $category);
        $color = $categoryData['color'] ?? 'bg-gray-300';
        return $color;
    }

    public function getColorLevel($level)
    {
        $levelData = collect(config('managerOne.levels'))->firstWhere('name', $level);
        $color = $levelData['color'] ?? 'bg-gray-300';
        return $color;
    }
   
    public function getColorWorkplace($workplace)
    {
        $workplaceData = collect(config('managerOne.workplaces'))->firstWhere('name', $workplace);
        $color = $workplaceData['color'] ?? 'bg-gray-300';
        return $color;
    }

    public function render()
    {
        $developers = User::query();

        if ($this->search) {
            $clients = $developers->where('name', 'like', '%' . $this->search . '%');
        }

        if ($this->searchCity) {
            $developers = $developers->where('city', 'like', '%' . $this->searchCity . '%');
        }

        if ($this->searchDate) {
            $developers = $developers->whereDate('created_at', '=', \Carbon\Carbon::parse($this->searchDate)->toDateString());
        }

        $developers = $developers->where('type', 'developer')->orWhere('type', 'pm')->get();
        
        $numberDevs = $developers->where('type', 'developer')->count();
        $numberPms = $developers->where('type', 'pm')->count();

        return view('livewire.developers.index-developers', compact('developers', 'numberDevs', 'numberPms'));
    }
}
