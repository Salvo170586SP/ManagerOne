<div class="-mt-2">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-bold mb-5">Gestione Tasks</h2>
        @if (session('message'))
            <div class="bg-gray-200 border dark:bg-[#474747] dark:border-0 mx-8 rounded relative mb-4">
                <span class="block p-5">{{ session('message') }}</span>
            </div>
        @endif
    </div>

    <div class="bg-white h-full p-6 border border-gray-300 rounded-lg">
        <div class="flex justify-between items-center mb-10">
            <div class="w-[350px] h-[32px]">
                <x-input type="search" wire:model.live="search" placeholder="Cerca.." shadow="false" />
            </div>
        </div>

        @if ($projects->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full border rounded-lg divide-y divide-gray-200">
                    <thead>
                    <tr>
                        <th scope="col"
                            class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                        </th>
                        <th scope="col"
                            class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                            Progetto</th>
                        <th scope="col"
                            class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                            Team
                        </th>
                        <th scope="col"
                            class="px-6 py-5 text-center text-xs font-medium border text-gray-500 uppercase tracking-wider">
                            Tasks
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
                    <tbody class="bg-white divide-y text-sm divide-gray-200" x-data="{ openRow: null }">
                    @foreach ($projects as $project)
                        <tr wire:key="projTask{{ $project->id }}-{{  str()->random(10) }}">
                            <td class="px-6 py-4 whitespace-nowrap w-[50px]">
                                @if ($project->tasks_count > 0)
                                    <x-button black flat class="w-2" icon="chevron-down" title="vedi tasks"
                                              @click="openRow === {{ $project->id }} ? openRow = null : openRow = {{ $project->id }}" />
                                @else
                                    <x-button light icon="no-symbol" class="w-2" />
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap w-[250px]">
                                <div class="text-sm">{{ $project->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap w-[250px]">
                                <div class="text-sm w-full">
                                    @isset($project->team->name)
                                        {{ $project->team->name }}
                                    @else
                                        -
                                    @endisset
                                </div>
                            </td>
                            <td class="px-6 py-4 flex justify-center">
                                <div
                                    class="bg-gray-200 border border-gray-300 font-bold h-7 w-7 flex items-center justify-center rounded-full">
                                    {{ $project->tasks_count }}
                                </div>
                            </td>
                            <td class="px-6 py-4 max-w-[80px] whitespace-nowrap text-center">
                                @if ($project->state)
                                    <div
                                        class="rounded ms-2 py-1 font-medium text-center {{ $this->getStateColor($project->state) }}">
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

                        <tr x-show="openRow == {{ $project->id }}" x-cloak>
                            <td colspan="6" class="bg-gray-50 p-0">
                                <div class="p-4 overflow-x-auto">
                                    <table class="w-full border divide-y divide-gray-200 bg-white">
                                        <thead>
                                        <tr>
                                            <th
                                                class="px-6 py-2 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                                Task</th>
                                            <th
                                                class="px-6 py-2 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                                Assegnato a</th>
                                            <th
                                                class="px-6 py-2 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                                Scadenza a</th>
                                            <th
                                                class="px-6 py-2 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                                Completato il</th>
                                        </tr>
                                        </thead>
                                        <tbody class="divide-y text-xs divide-gray-200">
                                        @foreach ($tasks->take(4) as $task)
                                            <tr wire:key="proj-task-{{ $project->id }}-{{ $task->id }}-{{  str()->random(10) }}">
                                                <td class="px-6 py-2">{{ \Illuminate\Support\Str::limit($task->title, 10) }}</td>
                                                <td class="px-6 py-2">{{ $task->developer->name ?? '-' }}</td>
                                                <td class="px-6 py-2">{{ $task->getDate($task->due_date) }} </td>
                                                <td class="px-6 py-2">{{ $task->getDate($task->completed_at) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td class="px-6 py-2 text-sm text-gray-500">....Vai nei dettagli per
                                                vedere altro</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="py-3">
                {{ $projects->links('vendor.pagination.tailwind') }}
            </div>
        @else
            <div class="text-sm text-center font-medium italic text-gray-400">
                Nessun progetto presente
            </div>
        @endif

    </div>
</div>