<div>
    <h2 class="text-xl font-bold mb-5">Dettagli Progetto</h2>
    <div class="flex mx-auto text-black h-[calc(100vh-7rem)]">
        <div class="w-[450px] h-auto bg-white p-5 me-5 rounded">
            <div class="font-bold text-sm text-center uppercase my-5">
                {{$project->name}}
            </div>
            <div class="flex items-center justify-start mb-5">
                <div class="font-medium text-sm">Cliente Proprietario:</div>
                <div class="text-sm ms-1">
                    {{$project->client->fullName()}}</div>
            </div>
            <div class="flex items-center justify-start mb-5">
                <div class="font-medium text-sm">Preventivo:</div>
                <div class="text-sm ms-1">
                    {{$project->preventive . ' €'}}
                </div>
            </div>
            <div class="flex  items-center justify-start mb-2">
                <div class="font-medium text-sm">Descrizione:</div>
                <x-button class="ms-5" slate icon="eye" x-on:click="$openModal('simpleModal-{{$project->id}}')" />
                <x-modal name="simpleModal-{{$project->id}}" blur="sm" align="center">
                    <x-card shadow="xl" class="max-w-[700px]">
                        <p class="text-base break-words">
                            {{$project->description ?? '-'}}
                        </p>
                        <x-slot name="footer" class="flex justify-end gap-x-4">
                            <x-button black label="Chiudi" x-on:click="close" />
                        </x-slot>
                    </x-card>
                </x-modal>
            </div>
        </div>

        <div class="w-full  p-6 bg-white rounded">
            <div class="w-full flex justify-between mb-5 pb-5">
                @if($project->is_available)
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-7 bg-green-600 rounded-full text-white">
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
                        stroke="currentColor" class="size-7 bg-red-600 rounded-full text-white">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <div class="ms-2 font-medium uppercase">
                        In Approvazione
                    </div>
                </div>
                @endif
                <x-button icon="arrow-left" black label="Torna ai Progetti" class="font-bold w-[200px] h-[32px]"
                    wire:navigate href="/projects" />
            </div>

            <div>
                <h3>Fattura</h3>
            </div>

        </div>
    </div>
</div>