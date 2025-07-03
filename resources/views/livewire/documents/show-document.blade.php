<div class="-mt-2 relative" x-data="{ isOpen: true }">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-bold mb-5">Documenti di {{ $user->fullName() }}</h2>
    </div>

    <div class="bg-white rounded-lg border border-gray-300 h-[calc(100vh-13rem)] overflow-y-auto p-6">
        <div class="flex justify-between items-center">
            <div class="w-[350px] h-[32px]">
                <x-input type="search" wire:model.live="search" placeholder="Cerca.." shadow="false" />
            </div>

            <div class="flex justify-between items-center">
                <div class="me-5 h-[32px] flex justify-between items-center">
                    <span class="text-sm whitespace-nowrap me-2">Data creazione:</span>
                    <x-datetime-picker without-time wire:model.live="searchDate" placeholder="Cerca per data"
                        shadow="false" />
                </div>
                <x-button icon="arrow-left" label="Torna all'Archivio" black wire:navigate href="/documents"
                    class="font-bold w-[200px] h-[32px]" />
            </div>
        </div>

        <x-card shadow="false" class="w-[350px] border border-gray-300 my-5">
            <div class="flex justify-between">
                <div class="bg-slate-500 w-[50px] h-[50px] rounded-full flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="white" class="size-7">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                </div>
                <div>
                    <div class="text-xl text-end font-bold">
                        @if ($user->type === 'developer')
                            {{ $notesWithAttachments->count() }}
                        @else
                            {{ $invoices->count() }}
                        @endif
                    </div>
                    <div class="text-sm">
                        Numero Documenti
                    </div>
                </div>
            </div>
        </x-card>

        @if ($user->type === 'client')
            <h3 class="text-sm font-bold mb-4">Allegati delle Fatture</h3>
            <div class="flex flex-wrap gap-3">
                @forelse ($invoices as $invoice)
                    <x-card shadow class="rounded-lg border border-gray-300 w-[300px] bg-blue-50/50">
                        <div class="text-end -mb-5">
                            <x-dropdown class="w-[150px]">
                                <x-dropdown.item icon="arrow-down-tray" label="Scarica"
                                    wire:click="downloadInvoicePdf({{ $invoice->id }})" />
                                <x-dropdown.item icon="eye" label="Visualizza"
                                    href="{{ asset('storage/' . $invoice->pdf_path) }}" target="_blank" />
                            </x-dropdown>
                        </div>
                        <div class="flex items-center justify-center h-[100px] border-b ">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-21">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                        </div>
                        <div class="flex items-center justify-between mt-2">
                            <div class="font-bold text-xs">{{ $invoice->name }}</div>
                        </div>
                        <div class="text-xs mb-1">
                            <small class="font-semibold">Creato il:</small>
                            {{ $invoice->created_at ? $invoice->created_at : '-' }}
                        </div>
                    </x-card>
                @empty
                    <div class="w-full flex flex-col items-center font-medium text-sm text-gray-500 py-10">
                        Cartella vuota, non ci sono documenti
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-21 mt-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 13.5H9m4.06-7.19-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                        </svg>
                    </div>
                @endforelse
            </div>
            <div class="mt-6">
                {{ $invoices->links() }}
            </div>
        @else
            <div class="mt-10">
                <h3 class="text-sm font-bold mb-4">Allegati delle Note</h3>
                <div class="flex flex-wrap gap-3">
                    @forelse ($notesWithAttachments as $note)
                        <x-card shadow class="rounded-lg border border-gray-300 w-[300px] bg-blue-50/50">
                            <div class="text-end -mb-5">
                                <x-dropdown class="w-[150px]">
                                    <x-dropdown.item icon="arrow-down-tray" label="Scarica" download
                                        href="{{ asset('storage/' . $note->url_file) }}" />
                                    <x-dropdown.item icon="eye" label="Visualizza"
                                        href="{{ asset('storage/' . $note->url_file) }}" target="_blank" />
                                </x-dropdown>
                            </div>
                            <div class="flex items-center justify-center h-[100px] border-b ">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-21">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                </svg>
                            </div>
                            <div class="flex items-center justify-between mt-2">
                                <div class="font-bold text-xs">{{ $note->title }}</div>
                            </div>
                            <div class="text-xs mb-1">
                                <small class="font-semibold">Creato il:</small>
                                {{ $note->created_at ? $note->created_at : '-' }}
                            </div>
                        </x-card>
                    @empty
                        <div class="w-full flex flex-col items-center font-medium text-sm text-gray-500 py-10">
                            Nessun allegato presente nelle note
                        </div>
                    @endforelse
                </div>
            </div>
        @endif
    </div>
</div>
