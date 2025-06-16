<div class="-mt-2">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-bold mb-5">Gestione dei Teams</h2>
        @if (session('message'))
            <div class="bg-gray-200 border dark:bg-[#474747] dark:border-0 mx-8 rounded relative mb-4">
                <span class="block p-5">{{ session('message') }}</span>
            </div>
        @endif
    </div>

    <div class="bg-white rounded p-6">
        <div class="flex justify-between items-center">
            <div class="w-[350px] h-[32px]">
                <x-input type="search" wire:model.live="search" placeholder="Cerca.." shadow="false" />
            </div>
            <div class="flex justify-between items-center">
                <x-button icon="plus" black label="Aggiungi Team" class="font-bold w-[200px] h-[32px]" wire:navigate
                    href="/teams/create" />
            </div>
        </div>

        <div class="flex items-center my-5 gap-3">
            <x-card shadow="false" class="w-[350px] border">
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

            <x-card shadow="false" class="w-[350px] border">
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

            <x-card shadow="false" class="w-[350px] border">
                <div class="flex justify-between">
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
                    <x-card color="blue" shadow="false" class="border">
                        <div class="flex justify-between items-center mb-5">
                            <div class="text-base font-bold uppercase">
                                {{ $team->name }}
                            </div>
                            <div class="flex justify-end items-center">
                                <x-button flat blue icon="pencil" wire:navigate
                                    href="/teams/{{ $team->id }}/edit" />
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
                                        <p class="font-semubold text-lg">
                                            Sei sicuro di eliminare definitivamente il team di sviluppo?
                                        </p>

                                        <x-slot name="footer" class="flex justify-end gap-x-4">
                                            <x-button black label="Annulla" x-on:click="close" />
                                            <x-button red label="Elimina"
                                                wire:click="deleteTeam({{ $team->id }})" />
                                        </x-slot>
                                    </x-card>
                                </x-modal>
                            </div>
                        </div>
                        <div class="flex justify-between items-center my-3">
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
                            <div
                                class="text-sm flex justify-center items-center border rounded-lg px-2 py-1 bg-gray-100 mx-2">
                                @if ($team->is_available)
                                    In progettazione
                                @else
                                    Disponibile
                                @endif
                            </div>
                        </div>

                        <hr>
                        <div>
                            @foreach ($team->pms as $pm)
                                <div class="my-5">
                                    <div class="text-sm font-bold">
                                        Project Manager
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <div class="text-base">
                                            {{ $pm->fullName() }}
                                        </div>
                                        <div>
                                            <x-button flat black icon="eye" wire:navigate
                                                href="/developers/{{ $pm->id }}" />
                                            <x-button flat red icon="trash"
                                                x-on:click="$openModal('pmTeam-{{ $pm->id }}')" />
                                            <x-modal name="pmTeam-{{ $pm->id }}" blur="sm"
                                                align="center">
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
                                                    <p class="font-semubold text-lg">
                                                        Sei sicuro di eliminare definitivamente il PM dal team di
                                                        sviluppo?
                                                    </p>

                                                    <x-slot name="footer" class="flex justify-end gap-x-4">
                                                        <x-button black label="Annulla" x-on:click="close" />
                                                        <x-button red label="Elimina"
                                                            wire:click="deleteMember({{ $pm->id }})" />
                                                    </x-slot>
                                                </x-card>
                                            </x-modal>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="my-5">
                                <div class="text-sm font-bold">
                                    Sviluppatori
                                </div>
                                @foreach ($team->developers->where('category', '!=', 'project manager') as $dev)
                                    <div class="flex justify-between items-center my-2">
                                        <div class="text-base ">
                                            {{ $dev->fullName() }}
                                        </div>
                                        <div>
                                            <x-button flat black icon="eye" wire:navigate
                                                href="/developers/{{ $dev->id }}" />
                                            <x-button flat red icon="trash"
                                                x-on:click="$openModal('devTeam-{{ $dev->id }}')" />
                                            <x-modal name="devTeam-{{ $dev->id }}" blur="sm"
                                                align="center">
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
                                                    <p class="font-semubold text-lg">
                                                        Sei sicuro di eliminare definitivamente il dev dal team di
                                                        sviluppo?
                                                    </p>

                                                    <x-slot name="footer" class="flex justify-end gap-x-4">
                                                        <x-button black label="Annulla" x-on:click="close" />
                                                        <x-button red label="Elimina"
                                                            wire:click="deleteMember({{ $dev->id }})" />
                                                    </x-slot>
                                                </x-card>
                                            </x-modal>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </x-card>
                @endforeach
            </div>
        @else
            <div class="text-center font-medium">
                Non ci sono teams registrati
            </div>
        @endif
    </div>
</div>
