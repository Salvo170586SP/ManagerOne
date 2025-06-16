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

        $developers = $developers->where('type', 'developer')->orWhere('type', 'project_manager')->get();
        
        $numberDevs = $developers->where('type', 'developer')->count();
        $numberPms = $developers->where('type', 'project_manager')->count();

        return view('livewire.developers.index-developers', compact('developers', 'numberDevs', 'numberPms'));
    }
}
