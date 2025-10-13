<div class="-mt-2">
    <div class="flex justify-between items-center h-20 -mt-7">
        <h2 class="text-xl font-bold">Gestione dei Teams</h2>
        <div x-data="{ showMessage: true }">
            @if (session('message'))
            <x-alert title="{{ session('message') }}" positive class="bg-green-600 text-white"
                x-init="setTimeout(() => showMessage = false, 5000)" x-show="showMessage" />
            @endif
        </div>
    </div>

    <div class="bg-white rounded-lg border border-gray-300 p-6">
        <div class="flex justify-between items-center">
            <div class="w-[350px] h-[32px]">
                <x-input type="search" wire:model.live="search" placeholder="Cerca.." shadow="false" />
            </div>
            @role('admin')
            <div class="flex justify-between items-center">
                <x-button icon="plus" black label="Aggiungi Team" class="font-bold w-[200px] h-[32px]" wire:navigate
                    href="/teams/create" />
            </div>
            @endrole
        </div>
        <div class="flex items-center my-5 gap-3">
            <x-card shadow="false" class="w-[350px] border border-gray-300">
                <div class="flex justify-between">
                    <div class="bg-slate-500 w-[50px] h-[50px] rounded-full flex justify-center items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="white" class="size-7">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-xl text-end font-bold">
                            {{ $teams->count() }}
                        </div>
                        <div class="text-sm">
                            Numero Teams
                        </div>
                    </div>
                </div>
            </x-card>

            <x-card shadow="false" class="w-[350px] border border-gray-300">
                <div class="flex justify-between">
                    <div class="bg-red-500 w-[50px] h-[50px] rounded-full flex justify-center items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="white" class="size-7">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-xl text-end font-bold">
                            {{ $teams->where('is_available', true)->count() }}
                        </div>
                        <div class="text-sm">
                            Teams In Progettazione
                        </div>
                    </div>
                </div>
            </x-card>

            <x-card shadow="false" class="w-[350px] border border-gray-300">
                <div class="flex justify-between ">
                    <div class="bg-green-500 w-[50px] h-[50px] rounded-full flex justify-center items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="white" class="size-7">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-xl text-end font-bold">
                            {{ $teams->where('is_available', false)->count() }}
                        </div>
                        <div class="text-sm">
                            Teams Disponibili
                        </div>
                    </div>
                </div>
            </x-card>

        </div>

        @if ($teams->count() > 0)
        <div class="grid grid-cols-3 gap-5">
            @foreach ($teams as $team)
            <x-card wire::key="team-{{ $team->id }}-{{ str()->random(10) }}" color="blue" shadow="false"
                class="border border-gray-300">
                <div class="flex justify-between items-center mb-5">
                    <div class="text-sm font-bold uppercase">
                        {{ $team->name }}
                    </div>
                    <div class="flex justify-end items-center">
                        @role('admin')
                        <x-button flat blue icon="eye" x-on:click="$openModal('openModalDetail-{{ $team->id }}')" />
                        <x-modal name="openModalDetail-{{ $team->id }}" blur="sm" align="center">
                            <x-card shadow="xl">
                                <div class="mb-5">
                                    <div class="text-sm font-bold">
                                        Progetto Assegnato
                                    </div>
                                    <div class="flex justify-start items-center">
                                        <div class="text-sm italic mt-2">
                                            @forelse ($team->projects as $project)
                                            <div>
                                                - {{ $project->name }}
                                            </div>
                                            @empty
                                            Nessun progetto
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-5">
                                    <div class="text-sm font-bold">
                                        Stato
                                    </div>
                                    <div class="flex justify-start items-center">
                                        <div class="text-sm italic mt-2">
                                            {{ $team->is_available ? 'In Progettazione' : 'Disponibile' }}
                                        </div>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <div class="border rounded-lg p-2">
                                        @foreach ($team->pms as $pm)
                                        <div wire::key="pmTeam-{{ $pm->id }}-{{ str()->random(10) }}" class="me-3">
                                            <div class="text-sm font-bold">
                                                Project Manager
                                            </div>
                                            <div class="flex justify-between items-center mt-2">
                                                <x-button flat black class="text-sm border" wire:navigate
                                                    href="/developers/{{ $pm->id }}" label="{{ $pm->fullName() }}" />
                                                <div class="ms-2">
                                                    @role('admin')
                                                    <x-button flat red icon="trash"
                                                        x-on:click="$openModal('pmTeam-{{ $pm->id }}')" />
                                                    <x-modal name="pmTeam-{{ $pm->id }}" blur="sm" align="center">
                                                        <x-card shadow="xl">
                                                            <div
                                                                class="flex items-center justify-center py-2 bg-red-400 text-white rounded-md mb-2 text-xl">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor" class="size-6 me-2">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                                                </svg>
                                                                Attenzione!
                                                            </div>
                                                            <p class="text-base">
                                                                Sei sicuro di eliminare definitivamente il
                                                                PM
                                                                dal team di
                                                                sviluppo?
                                                            </p>

                                                            <x-slot name="footer"
                                                                class="flex justify-end gap-x-4 font-medium">
                                                                <x-button black label="Annulla" x-on:click="close" />
                                                                <x-button red label="Elimina"
                                                                    wire:click="deleteMember({{ $pm->id }})" />
                                                            </x-slot>
                                                        </x-card>
                                                    </x-modal>
                                                    @endrole
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>

                                    <div class="border rounded-lg p-2">
                                        <div class="text-sm font-bold">
                                            Sviluppatori
                                        </div>
                                        @foreach ($team->developers->where('category', '!=', 'project manager') as $dev)
                                        <div wire::key="devTeam-{{ $dev->id }}-{{ str()->random(10) }}"
                                            class="flex justify-between items-center  mt-2">
                                            <x-button flat black class="text-sm border" wire:navigate
                                                href="/developers/{{ $dev->id }}" label="{{ $dev->fullName() }}" />
                                            <div class="ms-2">
                                                @role('admin')
                                                <x-button flat red icon="trash"
                                                    x-on:click="$openModal('devTeam-{{ $dev->id }}')" />
                                                <x-modal name="devTeam-{{ $dev->id }}" blur="sm" align="center">
                                                    <x-card shadow="xl">
                                                        <div
                                                            class="flex items-center justify-center py-2 bg-red-400 text-white rounded-md mb-2 text-xl">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor" class="size-6 me-2">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                                            </svg>
                                                            Attenzione!
                                                        </div>
                                                        <p class="text-base">
                                                            Sei sicuro di eliminare definitivamente il dev
                                                            dal team di
                                                            sviluppo?
                                                        </p>

                                                        <x-slot name="footer"
                                                            class="flex justify-end gap-x-4 font-medium">
                                                            <x-button black label="Annulla" x-on:click="close" />
                                                            <x-button red label="Elimina"
                                                                wire:click="deleteMember({{ $dev->id }})" />
                                                        </x-slot>
                                                    </x-card>
                                                </x-modal>
                                                @endrole
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                <x-slot name="footer" class="flex justify-end gap-x-4 font-medium">
                                    <x-button black label="Chiudi" x-on:click="close" />
                                </x-slot>
                            </x-card>
                        </x-modal>
                        <x-button flat blue icon="pencil" wire:navigate href="/teams/{{ $team->id }}/edit" />
                        <x-button flat red icon="trash" x-on:click="$openModal('team-{{ $team->id }}')" />
                        <x-modal name="team-{{ $team->id }}" blur="sm" align="center">
                            <x-card shadow="xl">
                                <div
                                    class="flex items-center justify-center py-2 bg-red-400 text-white rounded-md mb-2 text-xl">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6 me-2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                    </svg>
                                    Attenzione!
                                </div>
                                <p class="text-base">
                                    Sei sicuro di eliminare definitivamente il team di sviluppo?
                                </p>

                                <x-slot name="footer" class="flex justify-end gap-x-4 font-medium">
                                    <x-button black label="Annulla" x-on:click="close" />
                                    <x-button red label="Elimina" wire:click="deleteTeam({{ $team->id }})" />
                                </x-slot>
                            </x-card>
                        </x-modal>
                        @endrole
                    </div>
                </div>
                <hr>
                <div class="flex justify-between items-center my-4">
                    <div class="text-sm font-bold">
                        Numero Membri
                    </div>
                    <div
                        class="text-lg flex justify-center items-center bg-gray-100 border rounded-lg w-[35px] h-[25px] mx-2">
                        {{ $team->users->count() }}
                    </div>
                </div>
                <div class="flex justify-between items-center my-3">
                    <div class="text-sm font-bold">
                        Disponibilità
                    </div>
                    <div class="text-sm flex justify-center items-center border rounded-lg px-2 py-1 bg-gray-100 mx-2">
                        @if ($team->is_available)
                        In progettazione
                        @else
                        Disponibile
                        @endif
                    </div>
                </div>
            </x-card>
            @endforeach
        </div>
        <div class="py-3">
            {{ $teams->links('vendor.pagination.tailwind') }}
        </div>
        @else
        <div class="text-sm text-center font-medium italic text-gray-400">
            Non ci sono teams registrati
        </div>
        @endif
    </div>
</div>