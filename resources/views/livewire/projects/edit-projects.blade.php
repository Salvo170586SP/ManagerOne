<div>
    <h2 class="text-xl font-bold mb-5">Modifica Progetto</h2>
    <div class="bg-white rounded h-[calc(100vh-7rem)] overflow-y-auto p-6">

        <div class="flex justify-end items-center">
            <x-button icon="arrow-left" black label="Torna ai Progetti" class="font-bold w-[200px] h-[32px]"
                wire:navigate href="/projects" />
        </div>


        <form wire:submit.prevent="editProject" class="border-t my-4">
            <div class="flex gap-2 mt-5">
                <x-input label="Nome" shadow wire:model="name" />
                <x-input right-icon="currency-euro" label="Preventivo" shadow id="preventive" max="999999.99"
                    wire:model="preventive" />
                <x-select label="Cerca un Cliente" shadow placeholder="Seleziona un Cliente" wire:model="client_id"
                    :options="$clients" option-label="name" option-value="id" />
            </div>
            <div class="mt-5">
                <x-textarea label="Descrizione" wire:model="description" shadow />
            </div>
            <div class="flex flex-col gap-2 mt-5">
                <x-checkbox id="is_available" label="Approvato" wire:model="is_available" />
            </div>

            <div class="flex justify-end mt-5">
                <x-button type="submit" black label="Modifica" class="font-bold w-[200px] h-[32px]" />
            </div>
        </form>
    </div>
</div>