<div>
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Modifica Task</h2>
        <x-button icon="arrow-left" black label="Torna ai Tasks" wire:navigat href="/tasks/{{ $project->id }}/show"
            class="font-bold h-[32px]" />
    </div>
    <div class="bg-white p-6 border border-gray-300 rounded-lg">
        <form wire:submit.prevent="createTask" class="space-y-4">
            <x-input shadow label="Titolo" wire:model="title" id="title" />
            <x-textarea shadow wire:model="description" label="Descrizione" id="description" rows="3" />
            <div class="flex gap-3">
                <x-select shadow label="Cerca Developer" wire:model="developer_id" id="developer_id" :options="$developers"
                    option-label="name" option-value="id" />

                <x-select shadow label="Seleziona Stato" wire:model="state_task" id="state_task" :options="$states"
                    option-label="name" option-value="id" />

                <x-select shadow wire:model="priority" label="Priorità" id="priority" :options="$priorities"
                    option-label="name" option-value="id" />

                <x-datetime-picker label="Scadenza" without-time wire:model="due_date" id="due_date" shadow />
            </div>

            <div class="flex justify-end font-medium">
                <x-button black type="submit" label="Crea Task" />
            </div>
        </form>
    </div>
</div>
