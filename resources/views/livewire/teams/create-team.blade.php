<div class="-mt-2">
    <h2 class="text-xl font-bold mb-5">Aggiungi Team</h2>
    <div class="bg-white border border-gray-300 rounded-lg h-[calc(100vh-40rem)] overflow-y-auto p-6">

        <div class="flex justify-end items-center">
            <x-button icon="arrow-left" black label="Torna ai Teams" class="font-bold w-[200px] h-[32px]"
                wire:navigate href="/teams" />
        </div>

        <form wire:submit.prevent="addTeam" class="border-t my-4">
            <div class="flex gap-2 mt-5">
                <x-input label="Nome" id="name" shadow wire:model="name" />
                 <x-select label="Cerca un Project Manager" id="pm_id" shadow placeholder="Seleziona un Project Manager" wire:model="pm_id" :options="$pms"
                    option-label="name" option-value="id" />
                 <x-select multiselect label="Cerca un Developer"  id="developer_id" shadow placeholder="Seleziona un Developer" wire:model="developer_ids"   :options="$developers"
                    option-label="name" option-value="id" />
            </div>
            <div class="flex items-center gap-2 mt-5">
                <x-checkbox label="Disponibile" id="is_available" wire:model="is_available" />
            </div>
          
            <div class="flex justify-end mt-5">
                <x-button type="submit" black label="Aggiungi" class="font-bold w-[200px] h-[32px]" />
            </div>
        </form>
    </div>
</div>