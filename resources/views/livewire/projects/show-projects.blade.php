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
                    @if ($project->is_approved == 'approved')
                    <div class="bg-green-600 rounded-full  border border-green-800 text-green-50 px-5">
                        Approvato
                    </div>
                    @elseif($project->is_approved == 'pending_approval')
                    <div class="bg-yellow-200 rounded-full border border-yellow-800 text-yellow-800 px-5">
                        In Approvazione
                    </div>
                    @elseif($project->is_approved == 'not_approved')
                    <div class="bg-red-600 rounded-full  border border-red-800 text-white px-5">
                        Non Approvato
                    </div>
                    @else
                    <div class="bg-gray-200 rounded-full border border-gray-800 text-gray-800 px-5">
                        In Attesa
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
                        <div class="text-lg font-bold text-gray-700">
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

            @role('admin')
            <div class="flex gap-3">
                <div class="w-full flex items-center p-6 bg-white rounded-lg border border-gray-300">
                    <div class="text-sm w-full h-full">
                        <div class="flex justify-between items-center h-[70px] mb-5">
                            <h3 class="font-bold text-xl">Fatturazione</h3>
                            <div x-data="{ show: true }">
                                @if (session('message'))
                                <x-alert title="{{ session('message') }}" positive class="bg-green-600 text-white "
                                    x-init="setTimeout(() => show = false, 5000)" x-show="show" />
                                @endif
                            </div>

                            @if($project->is_approved == 'approved')
                            <x-button black label="Genera Fattura" class="font-bold w-[200px] h-[32px]"
                                wire:click="generateInvoicePdf" />
                            @endif
                        </div>

                        <table class="min-w-full divide-y border divide-gray-200">
                            <thead>
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                        Fattura</th>
                                    <th scope="col"
                                        class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                        Progetto
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                        Preventivo
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-5 text-center text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                        Pagato
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                        Data
                                        Creazione</th>
                                    <th scope="col"
                                        class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 text-sm">
                                @forelse ($invoices_project as $invoice)
                                <tr wire:key="invoice-{{ $invoice->id }}-{{  str()->random(10) }}">
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $invoice->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $invoice->project->name }}</td>
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
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div class="flex justify-center">
                                            <x-button gray flat icon="arrow-down-tray" label="Scarica" download
                                                href="{{ asset('storage/' . $invoice->pdf_path) }}" />
                                            <x-button gray flat icon="eye" label="Visualizza"
                                                href="{{ asset('storage/' . $invoice->pdf_path) }}" target="_blank" />
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr class="mb-3">
                                    <td class="text-sm text-center font-medium italic text-gray-400">Nessuna fattura
                                        disponibile</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endrole
        </div>
    </div>
</div>