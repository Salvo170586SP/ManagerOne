<div class="-mt-2">
    <div class="flex justify-between items-center h-20 -mt-7">
        <h2 class="text-xl font-bold">Fatture</h2>
        <div x-data="{ showMessage: true }">
            @if (session('message'))
                <x-alert title="{{ session('message') }}" positive class="bg-green-600 text-white" x-init="setTimeout(() => showMessage = false, 5000)"
                    x-show="showMessage" />
            @endif
        </div>
    </div>

    <div class="bg-white rounded-lg border border-gray-300 {{-- h-[calc(100vh-13rem)]  --}}overflow-y-auto p-6">
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

                <div class="h-[32px] flex justify-between items-center">
                    <span class="text-sm whitespace-nowrap me-2">Cerca per stato:</span>
                    <x-select shadow="false" placeholder="Seleziona Stato" wire:model.live="searchAvailable"
                        :options="[['label' => 'Pagato', 'value' => 1], ['label' => 'Non Pagato', 'value' => 0]]" option-label="label" option-value="value" />
                </div>
            </div>
        </div>

        <x-card shadow="false" class="w-[350px]  border border-gray-300 my-5">
            <div class="flex justify-between">
                <div class="bg-slate-500 w-[50px] h-[50px] rounded-full flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="white" class="size-7">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 11.625h4.5m-4.5 2.25h4.5m2.121 1.527c-1.171 1.464-3.07 1.464-4.242 0-1.172-1.465-1.172-3.84 0-5.304 1.171-1.464 3.07-1.464 4.242 0M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                </div>
                <div>
                    <div class="text-xl text-end font-bold">
                        {{ $invoices->count() }}
                    </div>
                    <div class="text-sm">
                        Numero Fatture
                    </div>
                </div>
            </div>
        </x-card>


        @if ($invoices->count() > 0)
            <div class="table-scroll-x">
                <table @if ($pollCondition) wire:poll.2s @endif
                    class="min-w-full divide-y border divide-gray-200">
                    <thead>
                        <tr>
                            <th scope="col"
                                class="sticky left-0 sticky-col-left px-6 py-5 text-center text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                ID</th>
                            <th scope="col"
                                class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                Nome</th>
                            <th scope="col"
                                class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                Nome Cliente
                            </th>
                            <th scope="col"
                                class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                Progetto
                            </th>
                            <th scope="col"
                                class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                Prezzo</th>
                            <th scope="col"
                                class="px-6 py-5 text-center text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                Stato Pagamento
                            </th>
                            <th scope="col"
                                class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                Data
                                Creazione</th>
                            <th scope="col"
                                class="sticky right-0 sticky-col-right px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y text-sm divide-gray-200">
                        @foreach ($invoices as $invoice)
                            <tr wire:key="invoice-{{ $invoice->id }}-{{ str()->random(10) }}">
                                <td class="sticky left-0 font-bold sticky-col-left px-6 py-4 whitespace-nowrap">
                                    @if ($invoice->IdInvoice)
                                        #IN-{{ $invoice->IdInvoice }}
                                    @else
                                        #IN
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $invoice->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $invoice->client_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @isset($invoice->project->name)
                                        {{ $invoice->project->name }}
                                    @else
                                        -
                                    @endisset
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $invoice->preventive }} €</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex justify-center items-center">
                                        @if ($invoice->is_available)
                                            <div class="bg-green-500 rounded-full text-white px-3">
                                                Pagato
                                            </div>
                                        @else
                                            <div class="bg-red-600 rounded-full text-white px-3">
                                                Non pagato
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $invoice->createDate() }}</td>
                                <td class="sticky right-0 sticky-col-right px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex justify-center gap-1">
                                        <x-button flat gray icon="arrow-down-tray" title="scarica fattura"
                                            wire:click="downloadInvoicePdf({{ $invoice->id }})" />
                                        <x-button flat black icon="eye" wire:navigate
                                            href="/invoices/{{ $invoice->id }}" />
                                        <x-button flat blue icon="pencil" wire:navigate
                                            href="/invoices/{{ $invoice->id }}/edit" />
                                        <x-button flat red icon="trash"
                                            x-on:click="$openModal('invoice-{{ $invoice->id }}')" />
                                        <x-modal name="invoice-{{ $invoice->id }}" blur="sm" align="center">
                                            <x-card shadow="xl">
                                                <div
                                                    class="flex items-center justify-center py-2 bg-red-400 text-white rounded-md mb-2 text-xl">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="size-6 me-2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                                    </svg>
                                                    Attenzione!
                                                </div>
                                                <p class="text-base">
                                                    Sei sicuro di eliminare definitivamente la fattura?
                                                </p>

                                                <x-slot name="footer" class="flex justify-end font-medium gap-x-4">
                                                    <x-button black label="Annulla" x-on:click="close" />
                                                    <x-button red label="Elimina"
                                                        wire:click="deleteInvoice({{ $invoice->id }})" />
                                                </x-slot>
                                            </x-card>
                                        </x-modal>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="py-3">
                {{ $invoices->links('vendor.pagination.tailwind') }}
            </div>
        @else
            <div class="text-sm text-center font-medium italic text-gray-400">
                Non ci sono fatture registrate
            </div>
        @endif
    </div>
</div>
