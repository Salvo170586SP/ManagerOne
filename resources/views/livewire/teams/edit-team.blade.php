<div class="-mt-2">
    <h2 class="text-xl font-bold mb-5">Modifica Team</h2>
    <div class="bg-white rounded h-[calc(100vh-13rem)] overflow-y-auto p-6">

        <div class="flex justify-end items-center">
            <x-button icon="arrow-left" black label="Torna ai Teams" class="font-bold w-[200px] h-[32px]" wire:navigate
                href="/teams" />
        </div>

        <form wire:submit.prevent="updateTeam" class="border-t my-4">
            <div class="flex gap-2 mt-5">
                <x-input label="Nome" id="name" shadow wire:model="name" />
                
                <x-select label="Project Manager" id="pm_id" shadow 
                    placeholder="Seleziona un Project Manager"
                    wire:model="pm_id" 
                    :options="$pms"  
                    wire:key="pm-select-{{ $team->id }}" 
                    option-label="name" 
                    option-value="id" />
               
                <x-select multiselect label="Developers" id="developer_id" shadow
                    placeholder="Seleziona i Developers" 
                    wire:key="dev-select-{{ $team->id }}" 
                    wire:model="developer_ids" 
                    :options="$developers"
                    option-label="name" 
                    option-value="id" />
            </div>

            <div class="flex items-center gap-2 mt-5">
                <x-checkbox label="Disponibilità Team" id="is_available" wire:model="is_available" />
            </div>

            <div class="flex justify-end mt-5">
                <x-button type="submit" black label="Modifica" class="font-bold w-[200px] h-[32px]" />
            </div>
        </form>
    </div>
</div>