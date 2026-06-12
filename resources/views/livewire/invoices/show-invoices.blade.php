<div class="-mt-2">
    <h2 class="text-xl font-bold mb-5">Dettagli Fattura</h2>
    <div class="flex gap-3 mx-auto text-black">
        <div class="w-[500px] bg-white p-5 rounded-lg border border-gray-300">
            <div class="h-full w-full flex items-center justify-center">
                @isset($invoice->pdf_path)
                <iframe class="w-full h-full rounded-lg border dark:border-[#505050] dark:bg-[#505050]"
                    src="{{ asset('/storage/'.$invoice->pdf_path) }}" type="application/pdf">
                </iframe>
                @endisset
            </div>
        </div>

        <div class="w-full h-full p-6 bg-white rounded-lg border border-gray-300">
            <div class="w-full flex justify-end mb-5 pb-5  border-b border-gray-300">

                <x-button icon="arrow-left" black label="Torna alle Fatture" class="font-bold w-[200px] h-[32px]"
                    wire:navigate href="/invoices" />

            </div>

            <div class="w-full  flex flex-col items-start justify-start">
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
                            @isset($invoice->project->name) {{$invoice->project->name}} @else - @endisset
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
                        <x-button class="ms-5" gray flat icon="eye"
                            x-on:click="$openModal('simpleModal-{{$invoice->id}}')" />
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
                </div>


                <div class="w-full flex items-center justify-between border-t border-gray-300 pt-3">
                    <div>
                        @if($invoice->is_available)
                        <div class="flex items-center bg-green-600 text-white rounded px-5 py-1">
                            <div class="font-bold">
                                Saldato
                            </div>
                        </div>
                        @else
                        <div class="flex items-center bg-red-600 rounded text-white px-5 py-1">
                            <div class="font-bold">
                               Da saldare
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="flex items-end">
                        <div class="font-medium text-sm">Importo Totale:</div>
                        <div class="text-3xl font-medium ms-5">
                            {{$invoice->preventive . ' €'}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>