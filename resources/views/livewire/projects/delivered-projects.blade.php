<div class="-mt-2">
    <div class="flex justify-between items-center h-20 -mt-7">
        <h2 class="text-xl font-bold">Progetti Consegnati</h2>
        <div x-data="{ showMessage: true }">
            @if (session('message'))
            <x-alert title="{{ session('message') }}" positive class="bg-green-600 text-white"
                x-init="setTimeout(() => showMessage = false, 5000)" x-show="showMessage" />
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
                            d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                    </svg>
                </div>
                <div>
                    <div class="text-xl text-end font-bold">
                        {{ $projects->count() }}
                    </div>
                    <div class="text-sm">
                        Numero Progetti Consegnati
                    </div>
                </div>
            </div>
        </x-card>



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
                        class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                        Team di sviluppo
                    </th>
                    <th scope="col"
                        class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                        Cliente
                    </th>
                    <th scope="col"
                        class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                        Preventivo</th>
                    <th scope="col"
                        class="px-6 py-5 text-center text-xs font-medium border text-gray-500 uppercase tracking-wider">
                        Approvato
                    </th>
                    <th scope="col"
                        class="px-6 py-5 text-center text-xs font-medium border text-gray-500 uppercase tracking-wider">
                        Stato Progettazione
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
            <tbody class="bg-white divide-y text-sm divide-gray-200">
                @foreach ($projects as $project)
                <tr wire:key="projectDelivered-{{ $project->id }}-{{  str()->random(10) }}">
                    <td class="px-6 py-4 font-bold whitespace-nowrap">
                        @if ($project->IdProject)
                        #PR-{{ $project->IdProject }}
                        @else
                        #PR
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $project->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $project->team->name ?? '-' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @role(['admin','projects_manager'])
                        <x-button wire:navigate href="/clients/{{ $project->client->id }}"
                            label="{{ $project->client->fullname() }}" class="border" black flat />
                        @endrole
                        @role('developer')
                        {{ $project->client->fullname() }}
                        @endrole
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap font-bold">€ {{ $project->preventive }} </td>
                    <td class="px-6 py-6 flex justify-center items-center">
                        <div class="flex justify-center items-center font-medium">
                            @if ($project->is_approved == 'approved')
                            <div class="bg-green-600 rounded-full  border border-green-800 text-green-50 px-5">
                                Approvato
                            </div>
                            @elseif($project->is_approved == 'pending_approval')
                            <div class="bg-yellow-200 rounded-full border border-yellow-800 text-yellow-800 px-5">
                                In Approvazione
                            </div>
                            @else
                            <div class="bg-red-600 rounded-full  border border-red-800 text-white px-5">
                                Non Approvato
                            </div>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <x-select shadow placeholder="Seleziona uno Stato"
                            wire:model.live="stateSelections.project-{{ $project->id }}" :options="$states_project"
                            option-label="name" option-value="id" class="{{ $selectColors[$project->id] }} rounded" />
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $project->createDate() }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <div class="flex justify-center">
                            <x-button flat black icon="eye" wire:navigate href="/projects/{{ $project->id }}" />
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
            Non ci sono progetti consegnati
        </div>
        @endif

    </div>
</div>