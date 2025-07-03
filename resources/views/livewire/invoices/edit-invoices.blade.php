<div class="-mt-2">
    <h2 class="text-xl font-bold mb-5">Modifica Fattura</h2>
    <div class="bg-white rounded-lg border border-gray-300 h-[calc(100vh-33rem)] overflow-y-auto p-6">
        <div class="flex justify-end items-center">
            <x-button icon="arrow-left" black label="Torna alle Fatture" class="font-bold w-[200px] h-[32px]"
                wire:navigate href="/invoices" />
        </div>
        <form wire:submit.prevent="editInvoice" class="border-t my-4">
            <div class="flex gap-2 mt-5">
                <x-input label="Nome" shadow wire:model="name" />
            </div>
            <div class="mt-5">
                <x-textarea label="Descrizione" wire:model="description" shadow />
            </div>
            <div class="flex flex-col gap-2 mt-5">
                <x-checkbox id="is_available" label="Fattura Pagata" wire:model="is_available" />
            </div>

            <div class="flex justify-end mt-5">
                <x-button type="submit" black label="Modifica" class="font-bold w-[200px] h-[32px]" />
            </div>
        </form>
    </div>
</div>
