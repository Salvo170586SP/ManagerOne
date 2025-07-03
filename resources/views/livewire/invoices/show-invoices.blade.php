<div class="-mt-2">
    <h2 class="text-xl font-bold mb-5">Dettagli Fattura</h2>
    <div class="flex gap-3 mx-auto text-black h-[calc(100vh-13rem)]">
        <div class="w-[800px] h-auto bg-white p-5 rounded-lg border border-gray-300">
            <div class="h-full w-full flex items-center justify-center">
                @isset($invoice->pdf_path)
                <iframe class="w-full h-full rounded-lg border dark:border-[#505050] dark:bg-[#505050]"
                    src="{{ asset('/storage/'.$invoice->pdf_path) }}" type="application/pdf">
                </iframe>
                @endisset
            </div>
        </div>

        <div class="w-full  p-6 bg-white rounded-lg border border-gray-300">
            <div class="w-full flex justify-between mb-5 pb-5  border-b border-gray-300">
                @if($invoice->is_available)
                <div class="flex items-center bg-green-600 text-white rounded px-5 py-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="white" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                    </svg>
                    <div class="ms-2 font-bold uppercase">
                        Pagata
                    </div>
                </div>
                @else
                <div class="flex items-center bg-red-600 rounded text-white px-5 py-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="white" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <div class="ms-2 font-bold uppercase">
                        Da Pagare
                    </div>
                </div>
                @endif
                <x-button icon="arrow-left" black label="Torna alle Fatture" class="font-bold w-[200px] h-[32px]"
                    wire:navigate href="/invoices" />
            </div>

            <div>
                <div class="flex items-center justify-start font-bold  my-5">
                    <div class="font-medium uppercase me-1">Fattura:</div>
                    {{$invoice->name}}
                </div>
                <div class="flex items-center justify-start mb-5">
                    <div class="font-medium text-sm">Fattura Cliente:</div>
                    <div class="text-sm ms-1">
                        {{$invoice->client_name}}</div>
                </div>
                <div class="flex items-center justify-start mb-5">
                    <div class="font-medium text-sm">Email Cliente:</div>
                    <div class="text-sm ms-1">
                      @isset($invoice->client->email) {{$invoice->client->email}} @else - @endisset</div>
                </div>
                <div class="flex items-center justify-start mb-5">
                    <div class="font-medium text-sm">Città Cliente:</div>
                    <div class="text-sm ms-1">
                        @isset($invoice->client->city) {{$invoice->client->city}} @else - @endisset</div>
                </div>
                <div class="flex items-center justify-start mb-5">
                    <div class="font-medium text-sm">Progetto:</div>
                    <div class="text-sm ms-1">
                      @isset($invoice->project->name)  {{$invoice->project->name}} @else - @endisset
                    </div>
                </div>
                <div class="flex items-center justify-start mb-5">
                    <div class="font-medium text-sm">Emissione Fattura:</div>
                    <div class="text-sm ms-1">
                        {{$invoice->createDate()}}
                    </div>
                </div>
                <div class="flex  items-center justify-start mb-5">
                    <div class="font-medium text-sm">Note Fattura:</div>
                    <x-button class="ms-5" gray flat icon="eye" x-on:click="$openModal('simpleModal-{{$invoice->id}}')" />
                    <x-modal name="simpleModal-{{$invoice->id}}" blur="sm" align="center">
                        <x-card shadow="xl" class="max-w-[700px]">
                            <p class="text-base break-words">
                                {{$invoice->description ?? 'Nessuna descrizione'}}
                            </p>
                            <x-slot name="footer" class="flex justify-end gap-x-4">
                                <x-button black label="Chiudi" x-on:click="close" />
                            </x-slot>
                        </x-card>
                    </x-modal>
                </div>
                <div class="flex items-center justify-start mb-5">
                    <div class="font-medium text-lg">Importo Totale Fattura:</div>
                    <div class="text-lg font-medium ms-1 ">
                        {{$invoice->preventive . ' €'}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>