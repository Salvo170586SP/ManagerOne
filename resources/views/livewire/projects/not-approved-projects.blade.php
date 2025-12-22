<div class="-mt-2 relative" x-data="{ isOpen: true }">
    <div class="flex justify-between items-center h-20 -mt-7">
        <h2 class="text-xl font-bold">Progetti Non Approvati</h2>
    </div>
    <div class="bg-white rounded-lg border border-gray-300 overflow-y-auto p-6">
        <div class="flex justify-between items-center">
            <div class="w-[350px] h-[32px]">
                <x-input type="search" wire:model.live="search" placeholder="Cerca.." shadow="false" />
            </div>

            <div class="flex justify-between items-center">
                <div class="h-[32px] flex justify-between items-center">
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
                        stroke="currentColor" class="size-7 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>

                </div>
                <div>
                    <div class="text-xl text-end font-bold">
                        {{ $projectsNotApproved->count() }}
                    </div>
                    <div class="text-sm">
                        Numero Progetti Non Approvati
                    </div>
                </div>
            </div>
        </x-card>




        @if ($projectsNotApproved->count() > 0)
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
                        Cliente
                    </th>
                    <th scope="col"
                        class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                        Preventivo</th>
                    <th scope="col"
                        class="px-6 py-5 text-center text-xs font-medium border text-gray-500 uppercase tracking-wider">
                        Stato Approvazione
                    </th>
                    <th scope="col"
                        class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                        Data
                        Creazione</th>
                    <th scope="col"
                        class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                        Data
                        Consegna</th>
                    <th scope="col"
                        class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 text-sm">
                @foreach ($projectsNotApproved as $project)
                <tr wire:key="projectsNotApproved-{{ $project->id }}-{{ str()->random(10) }}">
                    <td class="px-6 py-4 font-bold whitespace-nowrap">
                        @if ($project->IdProject)
                        #PR-{{ $project->IdProject }}
                        @else
                        #PR
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $project->name }}</td>
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
                    <td class="px-6 py-4 whitespace-nowrap">
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
                    <td class="px-6 py-4 whitespace-nowrap">{{ $project->createDate() }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $project->getEndDate() }}</td>
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
            {{ $projectsNotApproved->links('vendor.pagination.tailwind') }}
        </div>
        @else
        <div class="text-sm text-center font-medium italic text-gray-400">
            Non ci sono progetti registrati
        </div>
        @endif

    </div>
</div>