<div>
    <h3 class="text-xl font-semibold ">Progetti</h3>
    <x-card shadow="false" class="w-[350px] border border-gray-300 rounded-lg my-5">
        <div class="flex justify-between">
            <div class="bg-slate-500 w-[50px] h-[50px] rounded-full flex justify-center items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="white" class="size-7">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5m.75-9 3-3 2.148 2.148A12.061 12.061 0 0 1 16.5 7.605" />
                </svg>
            </div>
            <div>
                <div class="text-xl text-end font-bold">
                    {{ $client->projects->count() }}
                </div>
                <div class="text-sm">
                    Totale Progetti
                </div>
            </div>
        </div>
    </x-card>

    <div>
        @if ($projectClient->count() > 0)
        <table class="min-w-full divide-y border divide-gray-200">
            <thead>
                <tr>
                    <th scope="col"
                        class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                        ID</th>
                    <th scope="col"
                        class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                        Nome
                    </th>
                    <th scope="col"
                        class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                        Preventivo
                    </th>
                    <th scope="col"
                        class="px-6 py-5 text-center text-xs font-medium border text-gray-500 uppercase tracking-wider">
                        Stato
                        Approvazione</th>
                    <th scope="col"
                        class="px-6 py-5 text-center text-xs font-medium border text-gray-500 uppercase tracking-wider">
                        Stato
                        Progettazione</th>
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
                @foreach ($projectClient as $project)
                <tr wire:key="clientproject-{{ $project->id }}-{{  str()->random(10) }}">
                    <td class="px-6 py-4 whitespace-nowrap font-bold">#PR-{{ $project->IdProject }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $project->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $project->preventive }} €</td>
                    <td class="px-6 py-4 flex justify-center text-center whitespace-nowrap">
                        <div class="flex justify-center items-center font-medium">
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
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if ($project->state)
                        <div class="rounded ms-2 font-medium text-center {{ $this->getStateColor($project->state) }}">
                            {{ $this->getStateName($project->state) }}
                        </div>
                        @else
                        -
                        @endif
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
            {{ $projectClient->links('vendor.pagination.tailwind') }}
        </div>
        @else
        <div class="text-sm text-center font-medium italic text-gray-400 py-10">
            Non ci sono progetti associati a questo cliente
        </div>
        @endif
    </div>
</div>