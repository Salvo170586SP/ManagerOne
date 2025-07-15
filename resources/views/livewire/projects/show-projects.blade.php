<div class="-mt-2">
    <div class="flex justify-between items-center  mb-5">
        <h2 class="text-xl font-bold">Dettagli Progetto</h2>
        <x-button icon="arrow-left" black label="Torna ai Progetti" class="font-bold w-[200px] h-[32px]" wire:navigate
            href="/projects" />
    </div>
    <div class="text-black w-full">
        <div class="w-full flex gap-3 mb-3">
            <div class="bg-white rounded-lg border border-gray-300 p-3 w-[350px] flex flex-col justify-center">
                <div class="mb-3">
                    <div class="font-medium text-sm">Nome Progetto:</div>
                    <div class="text-sm mt-1 ">
                        {{ $project->name }}
                    </div>
                </div>

                <div class="font-medium text-sm">Stato Approvazione:</div>
                <div class="font-medium rounded text-sm text-center py-1 mt-1">
                    @if ($project->is_available)
                        <div class="bg-green-600 rounded-full text-white">
                            Approvato
                        </div>
                    @else
                        <div class="bg-red-600 rounded-full text-white">
                            Da Approvare
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-lg border border-gray-300 p-3 w-[350px] flex flex-col justify-center">
                <div class="mb-3">
                    <div class="font-medium text-sm">Cliente Proprietario:</div>
                    <div class="text-sm uppercase mt-1">
                        {{ $project->client->fullName() }}</div>
                </div>

                <div class="font-medium text-sm">Preventivo:</div>
                <div class="text-sm mt-1">
                    {{ $project->preventive . ' €' ?? '-' }}
                </div>
            </div>

            <div class="bg-white rounded-lg  border border-gray-300 p-3 w-[350px] flex flex-col justify-center">
                <div class="mb-3">
                    <div class="font-medium text-sm">Data Consegna:</div>
                    <div class="text-sm mt-1">
                        {{ $project->getEndDate() }}
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="font-medium text-sm me-1">Descrizione:</div>
                    <x-button flat slate icon="eye" x-on:click="$openModal('simpleModal-{{ $project->id }}')" />
                    <x-modal name="simpleModal-{{ $project->id }}" blur="sm" align="center">
                        <x-card shadow="xl" class="max-w-[700px]">
                            <div class="p-4">
                                <p class="text-base break-words">
                                    {{ $project->description ?? 'Nessuna descrizione' }}
                                </p>
                            </div>
                            <x-slot name="footer" class="flex justify-end gap-x-4">
                                <x-button black label="Chiudi" x-on:click="close" />
                            </x-slot>
                        </x-card>
                    </x-modal>
                </div>
            </div>

            <div class="bg-white rounded-lg border border-gray-300  p-3 w-[350px] flex flex-col justify-center">
                <div class="font-medium text-sm">Affidato al Team:</div>
                <div class="text-sm mt-1">
                    @isset($project->team->name)
                        {{ $project->team->name }}
                    @else
                        -
                    @endisset
                </div>
            </div>
        </div>

        <div class="w-full">
            <div class="mb-5 p-6 bg-white rounded-lg border border-gray-300 pb-5">
                <div class="flex justify-between">
                    <h3 class="font-bold text-xl">Avanzamento Stato Progettazione</h3>

                </div>

                <div class="mt-5">
                    <div class="flex justify-between items-center mb-2">
                        <div class="text-lg font-medium text-gray-700">
                            {{ $project->getProgressPercentage() }}%
                        </div>
                        <div class="text-sm font-medium text-gray-700">
                            Tempo rimanente: {{ $project->getRemainingTime() }}
                        </div>
                    </div>
                    {{-- barra di progresso --}}
                    <div class="w-full bg-gray-200 rounded-full h-1.5">
                        <div class="bg-gray-600 h-1.5 rounded-full transition-all duration-500"
                            style="width: {{ $project->getProgressPercentage() }}%">
                        </div>
                    </div>
                    <div class="mt-2 text-sm text-gray-600">
                        Data di fine prevista: {{ $project->getEndDate() }}
                    </div>
                </div>
            </div>

            <div class="flex gap-3">
                @role('super_admin')
                    <div class="  flex items-center p-6 bg-white rounded-lg border border-gray-300">
                        <div class="text-sm w-full h-full">
                            <h3 class="font-bold text-xl mb-5">Fatturazione</h3>
                            @forelse ($project->invoices as $invoice)
                                <div wire:key="inv-{{ $invoice->id }}" class="flex gap-5 ">
                                    <div class="flex flex-col bg-gray-50 border border-gray-300 rounded-lg p-3">
                                        <div class="mb-3">
                                            <div class="font-semibold text-sm me-2">Fattura:</div>
                                            <div class="text-lg">
                                                {{ $invoice->name }}
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="font-semibold text-sm me-2">Importo:</div>
                                            <div class="text-lg">
                                                {{ $invoice->preventive }} €
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="font-semibold text-sm me-2">Data erogazione:</div>
                                            <div class="text-lg">
                                                {{ $invoice->createDate() }}
                                            </div>
                                        </div>
                                    </div>
                                    @isset($invoice->pdf_path)
                                        <iframe
                                            class="h-[400px] w-[300px]  rounded-lg border dark:border-[#505050] dark:bg-[#505050]"
                                            src="{{ asset('/storage/' . $invoice->pdf_path) }}" type="application/pdf">
                                        </iframe>
                                    @endisset

                                @empty
                                    <div class="mb-3">
                                        <div class="text-sm text-center font-medium italic text-gray-400">Nessuna fattura disponibile</div>
                                    </div>
                            @endforelse
                        </div>
                    </div>
                @endrole


            </div>
        </div>


    </div>

</div>
