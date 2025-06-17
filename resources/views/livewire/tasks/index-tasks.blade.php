<div class="-mt-2">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-bold mb-5">Gestione Tasks</h2>
        @if (session('message'))
            <div class="bg-gray-200 border dark:bg-[#474747] dark:border-0 mx-8 rounded relative mb-4">
                <span class="block p-5">{{ session('message') }}</span>
            </div>
        @endif
    </div>

    <div class="bg-white rounded h-full p-6">
        <div class="flex justify-between items-center mb-10">
            <div class="w-[350px] h-[32px]">
                <x-input type="search" wire:model.live="search" placeholder="Cerca.." shadow="false" />
            </div>
        </div>

        @if ($projects->count() > 0)
            <table class="min-w-full border divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th scope="col"
                            class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                            Progetto</th>
                        <th scope="col"
                            class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                            Team
                        </th>
                        <th scope="col"
                            class="px-6 py-5 text-center text-xs font-medium border text-gray-500 uppercase tracking-wider">
                            Stato
                        </th>
                        <th scope="col"
                            class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y text-sm divide-gray-200">
                    @foreach ($projects as $project)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm">{{ $project->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm">@isset($project->team->name) {{ $project->team->name }} @else - @endisset</div>
                            </td>
                            <td class="px-6 py-4 max-w-[80px] whitespace-nowrap text-center">
                                @if ($project->state)
                                    <div
                                        class="rounded ms-2 font-medium text-center {{ $this->getStateColor($project->state) }}">
                                        {{ $this->getStateName($project->state) }}
                                    </div>
                                @else
                                -
                                @endif
                            </td>
                            <td class="whitespace-nowrap text-sm text-center text-gray-500">
                                <x-button icon="eye" gray flat wire:navigate title="Vedi dettagli"
                                    href="/tasks/{{ $project->id }}/show" class="font-bold h-[32px]" />
                                @if ($project->state !== 'Annullato')
                                    <x-button icon="plus" flat blue title="Aggiungi Tasks" wire:navigate
                                        href="/tasks/{{ $project->id }}/create" class="font-bold h-[32px]" />
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="py-3">
                {{ $tasks->links('vendor.pagination.tailwind') }}
            </div>
        @else
            <div class="px-6 py-4 text-center text-gray-500">
                Nessuna progetto presente
            </div>
        @endif

    </div>
</div>
