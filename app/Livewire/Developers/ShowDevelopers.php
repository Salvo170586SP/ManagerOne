<?php

namespace App\Livewire\Developers;

use App\Models\User;
use Livewire\Component;

class ShowDevelopers extends Component
{
    public $developer;

    public function mount(User $developer)
    {
        $this->developer = $developer;
    }

    public function getColorType($type)
    {
        $typesData = collect(config('managerOne.types'))->firstWhere('name', $type);
        $color = $typesData['color'] ?? 'bg-gray-300';
        return $color;
    }
 
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
        return view('livewire.developers.show-developers');
    }
}
