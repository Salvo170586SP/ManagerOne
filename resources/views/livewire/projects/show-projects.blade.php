<div class="-mt-2">
    <h2 class="text-xl font-bold mb-5">Dettagli Progetto</h2>
    <div class="flex mx-auto text-black h-full w-full">

        <div class="w-[450px] h-[400px] bg-white p-5 me-5 rounded">
            <div class="font-bold text-sm text-center uppercase my-5">
                {{ $project->name }}
            </div>
            <div class="mb-5 flex justify-between items-center">
                @if ($project->is_available)
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-5 bg-green-600 rounded-full text-white">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                        </svg>
                        <div class="ms-2 font-medium uppercase">
                            Approvato
                        </div>
                    </div>
                @else
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-5 bg-red-600 rounded-full text-white">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <div class="ms-2 font-medium uppercase">
                            In Approvazione
                        </div>
                    </div>
                @endif
            </div>
            <div class="flex items-center justify-start mb-5">
                <div class="font-medium text-sm">Cliente Proprietario:</div>
                <div class="text-sm ms-1">
                    {{ $project->client->fullName() }}</div>
            </div>
            <div class="flex items-center justify-start mb-5">
                <div class="font-medium text-sm">Preventivo:</div>
                <div class="text-sm ms-1">
                    {{ $project->preventive . ' €' }}
                </div>
            </div>

            <div class="flex  items-center justify-start mb-2">
                <div class="font-medium text-sm">Descrizione:</div>
                <x-button class="ms-5" slate icon="eye"
                    x-on:click="$openModal('simpleModal-{{ $project->id }}')" />
                <x-modal name="simpleModal-{{ $project->id }}" blur="sm" align="center">
                    <x-card shadow="xl" class="max-w-[700px]">
                        <p class="text-base break-words">
                            {{ $project->description ?? '-' }}
                        </p>
                        <x-slot name="footer" class="flex justify-end gap-x-4">
                            <x-button black label="Chiudi" x-on:click="close" />
                        </x-slot>
                    </x-card>
                </x-modal>
            </div>
            <div class="flex flex-col items-start mb-5">
                <div class="font-medium text-sm mb-2">Progetto affidato al Team:</div>
                <div class="text-sm uppercase border rounded px-2 py-1 bg-gray-50 text-center">
                    {{ $project->team->name }}
                </div>
            </div>
        </div>

        <div class="w-full">
            <div class="mb-5 flex items-center p-6 bg-white rounded">
                <div class="text-sm w-full h-full ">
                    <div class="flex justify-between items-center mb-5">
                        <h3 class="font-bold text-xl ">Fatturazione</h3>
                        <x-button icon="arrow-left" black label="Torna ai Progetti" class="font-bold w-[200px] h-[32px]"
                            wire:navigate href="/projects" />
                    </div>
                    @foreach ($project->invoices as $invoice)
                        <div class="flex gap-5">
                            @isset($invoice->pdf_path)
                                <iframe
                                    class="h-[500px] w-[400px]  rounded-lg border dark:border-[#505050] dark:bg-[#505050]"
                                    src="{{ asset('/storage/' . $invoice->pdf_path) }}" type="application/pdf">
                                </iframe>
                            @endisset
                            <div class="mb-5">
                                <div>
                                    <div class="font-semibold text-sm me-2">Fattura:</div>
                                    <div class="text-lg">
                                        {{ $invoice->name }}
                                    </div>
                                </div>
                                <div>
                                    <div class="font-semibold text-sm me-2">Importo:</div>
                                    <div class="text-lg">
                                        {{ $invoice->preventive }} €
                                    </div>
                                </div>
                                <div>
                                    <div class="font-semibold text-sm me-2">Data erogazione:</div>
                                    <div class="text-lg">
                                        {{ $invoice->createDate() }}
                                    </div>
                                </div>


                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-between mb-5 p-6 bg-white rounded pb-5">
                <h3 class="font-bold text-xl">Stato di Progettazione</h3>
                <span class="rounded px-2 py-1 font-bold text-lg @if($project->state == 'Consegnato') bg-gray-200 @elseif($project->state == 'In Progettazione') bg-yellow-200 @else bg-red-200   @endif">
                    {{ $project->state }}
                </span>
            </div>

        </div>

    </div>

</div>
</div>
