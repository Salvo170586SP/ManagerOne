<div class="-mt-2">
    <div class="flex justify-between items-center h-20 -mt-7">
        <h2 class="text-xl font-bold">Progetti Approvati</h2>
        <div x-data="{ showMessage: true }">
            @if (session('message'))
                <x-alert title="{{ session('message') }}" positive class="bg-green-600 text-white" x-init="setTimeout(() => showMessage = false, 5000)"
                    x-show="showMessage" />
            @endif
        </div>
    </div>

    <div class="bg-white rounded-lg border border-gray-300 {{-- h-[calc(100vh-13rem)] --}} overflow-y-auto p-6">
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
            </div>
        </div>

        <x-card shadow="false" class="w-[350px] border border-gray-300 my-5">
            <div class="flex justify-between">
                <div class="bg-slate-500 w-[50px] h-[50px] rounded-full flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="white" class="size-7">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                    </svg>
                </div>
                <div>
                    <div class="text-xl text-end font-bold">
                        {{ $projects->count() }}
                    </div>
                    <div class="text-sm">
                        Numero Progetti Approvati
                    </div>
                </div>
            </div>
        </x-card>


        <div {{-- class="overflow-x-auto" --}}>
            @if ($projects->count() > 0)
                <table class="min-w-full divide-y border divide-gray-200">
                    <thead>
                        <tr>
                            <th scope="col"
                                class="px-6 py-5 text-center text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                ID</th>
                            <th scope="col"
                                class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                Nome</th>
                            <th scope="col"
                                class="px-6 py-5 text-center text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                Team di sviluppo
                            </th>
                            <th scope="col"
                                class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                Cliente
                            </th>
                            @role(['super_admin', 'project_manager'])
                                <th scope="col"
                                    class="px-6 py-5 text-center text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                    Note
                                </th>
                            @endrole
                            <th scope="col"
                                class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                Preventivo</th>
                            @role(['super_admin', 'project_manager'])
                                <th scope="col"
                                    class="px-6 py-5 text-center text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                    Stato Progettazione
                                </th>
                            @endrole
                            <th scope="col"
                                class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                Data
                                Creazione</th>
                            <th scope="col"
                                class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y text-sm divide-gray-200">
                        @foreach ($projects as $project)
                            <tr wire:key="projectApproved-{{ $project->id }}-{{ str()->random(10) }}">
                                <td class="px-6 py-4 font-bold whitespace-nowrap">
                                    @if ($project->IdProject)
                                        #PR-{{ $project->IdProject }}
                                    @else
                                        #PR
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $project->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @role('developer')
                                        @if ($project->team)
                                            {{ $project->team->name }}
                                        @else
                                            -
                                        @endif
                                    @endrole

                                    @role(['super_admin', 'project_manager'])
                                        @if (count($teams) > 0)
                                            <x-select red shadow placeholder="Seleziona un Team"
                                                wire:model.live="teamSelections.project-{{ $project->id }}"
                                                :options="$teams" option-label="name" option-value="id" />
                                        @else
                                            <span class="text-gray-500 italic">Nessun team selezionabile</span>
                                        @endif
                                    @endrole
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $project->client->fullName() }}</td>
                                @role(['super_admin', 'project_manager'])
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <x-button flat blue icon="document-text" class="relative"
                                            wire:click="openNotesSidebar({{ $project->id }})" title="Visualizza Note">
                                            <div
                                                class="absolute right-2 top-0  rounded-full bg-blue-500 h-[15px] w-[15px] text-center text-xs font-bold text-white">
                                                {{ $project->notes->count() }}</div>
                                        </x-button>
                                    </td>
                                @endrole
                                <td class="px-6 py-4 whitespace-nowrap">{{ $project->preventive }} €</td>
                                @role(['super_admin', 'project_manager'])
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <x-select shadow placeholder="Seleziona uno Stato"
                                            wire:model.live="stateSelections.project-{{ $project->id }}" :options="$states_project"
                                            option-label="name" option-value="id"
                                            class="{{ $selectColors[$project->id] }} rounded" />
                                    </td>
                                @endrole
                                <td class="px-6 py-4 whitespace-nowrap">{{ $project->createDate() }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex justify-center">
                                        <x-button flat black icon="eye" wire:navigate
                                            href="/projects/{{ $project->id }}" />
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="py-3">
                    {{ $projects->links('vendor.pagination.tailwind') }}
                </div>
            @else
                <div class="text-sm text-center font-medium italic text-gray-400">
                    Non ci sono progetti approvati
                </div>
            @endif
        </div>
    </div>

    <!-- Componente Sidebar per le Note -->
    <x-notes-sidebar wire:model="showDrawer2" :notes="$selectedProjectNotes" :item="$selectedProject" :edit-note-id="$editNoteId"
        onClose="closeNotesSidebar" />
</div>
