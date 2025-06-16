<?php

namespace App\Livewire\Developers;

use App\Models\User;
use App\Models\Task;
use Livewire\Component;
use Illuminate\Support\Collection;

class ShowDevelopers extends Component
{
    public $developer;
    public Collection $taskDates;

    public function mount(User $developer)
    {
        $this->developer = $developer;
        $this->taskDates = collect();
        
        // Initialize taskDates with current completed_at values
        foreach ($developer->tasks as $task) {
            $this->taskDates[$task->id] = $task->completed_at ? $task->completed_at->format('Y-m-d\TH:i') : '';
        }
    }
   
    public function changeDate($task_id)
    {
        
        $task = Task::find($task_id);
        
        if ($task) {
            $task->update([
                'completed_at' => $this->taskDates[$task_id] ?: null
            ]);
        }
    }

    public function getColorType($type)
    {
        $typesData = collect(config('managerOne.types'))->firstWhere('id', $type);
        $color = $typesData['color'] ?? 'bg-gray-300';
        return $color;
    }

    public function getNameType($type)
    {
        $typesData = collect(config('managerOne.types'))->firstWhere('id', $type);
        $name = $typesData['name'] ?? '-';
        return $name;
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

    public function getPriorityName($priority)
    {
        $taskData = collect(config('managerOne.priorities_task'))->first(function ($item) use ($priority) {
            return $item['id'] === $priority || $item['name'] === $priority;
        });
        return $taskData['name'] ?? $priority;
    }

    public function getColorPriorityTask($task)
    {
        $priorityId = is_string($task) ? $task : $task->priority;
        $taskData = collect(config('managerOne.priorities_task'))->first(function ($item) use ($priorityId) {
            return $item['id'] === $priorityId || $item['name'] === $priorityId;
        });

        return $taskData['color'] ?? 'bg-gray-300';
    }
   
    public function getStatusNameTask($priority)
    {
        $taskData = collect(config('managerOne.states_task'))->first(function ($item) use ($priority) {
            return $item['name'] === $priority;
        });
        return $taskData['name'] ?? $priority;
    }

    public function getColorStatusTask($task)
    {
        $priorityId = is_string($task) ? $task : $task->priority;
        $taskData = collect(config('managerOne.states_task'))->first(function ($item) use ($priorityId) {
            return $item['name'] === $priorityId;
        });

        return $taskData['color'] ?? 'bg-gray-300';
    }

    public function render()
    {
        return view('livewire.developers.show-developers');
    }
}
