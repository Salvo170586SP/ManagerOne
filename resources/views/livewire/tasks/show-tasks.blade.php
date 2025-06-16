<div class="-mt-2">
    <h2 class="text-xl font-bold mb-5">Dettagli Tasks</h2>
    <div class="flex mx-auto text-black h-full w-full">

        <div class="w-[450px] h-[430px] bg-white p-5 me-5 rounded">
            <div class="mb-5">
                <div class="font-medium text-sm">Nome Progetto:</div>
                <div class="text-sm mt-1">
                    {{ $project->name }}
                </div>
            </div>
            <div class="mb-5">
                @if ($project->state)
                    <div class="font-medium text-sm">Stato Progetto:</div>
                    <div
                        class="font-medium rounded text-sm text-center max-w-[150px] py-1 mt-1 {{ $this->getStateColor($project->state) }}">
                        {{ $this->getStateName($project->state) }}
                    </div>
                @endif
            </div>
            <div class="mb-5">
                <div class="font-medium text-sm">Cliente Proprietario:</div>
                <div class="text-sm  mt-1">
                    {{ $project->client->fullName() }}</div>
            </div>
            <div class="mb-5">
                <div class="font-medium text-sm">Preventivo:</div>
                <div class="text-sm mt-1">
                    {{ $project->preventive . ' €' }}
                </div>
            </div>

            <div class="mb-5 flex items-center">
                <div class="font-medium text-sm me-1">Descrizione:</div>
                <x-button flat slate icon="eye" x-on:click="$openModal('simpleModal-{{ $project->id }}')" />
                <x-modal name="simpleModal-{{ $project->id }}" blur="sm" align="center">
                    <x-card shadow="xl" class="max-w-[700px]">
                        <div class="p-4">
                            <p class="text-base break-all whitespace-pre-wrap">
                                {{ $project->description ?? '-' }}
                            </p>
                        </div>
                        <x-slot name="footer" class="flex justify-end gap-x-4">
                            <x-button black label="Chiudi" x-on:click="close" />
                        </x-slot>
                    </x-card>
                </x-modal>
            </div>
            <div class="flex flex-col items-start mb-5">
                <div class="font-medium text-sm">Progetto affidato al Team:</div>
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
            <div class="mb-5 flex items-center p-6 bg-white rounded">
                <div class="text-sm w-full h-full ">
                    <div class="flex justify-between items-center mb-5">
                        <h3 class="font-bold text-xl ">Tasks</h3>
                        <x-button icon="arrow-left" black label="Torna ai Tasks" class="font-bold w-[200px] h-[32px]"
                            wire:navigate href="/tasks" />
                    </div>

                    @if ($project->tasks->count() > 0)
                        <table class="min-w-full border divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                        Nome Task</th>
                                    <th scope="col"
                                        class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                        Assegnato a
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-5 text-center text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                        Priorità
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-5 text-center text-xs font-medium border text-gray-500 uppercase tracking-wider">

                                        Scadenza
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-5 text-center text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                        Chiusura Task
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-5 text-center text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                        Progressione
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($project->tasks as $task)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm">{{ $task->title }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm">@isset($task->developer) {{ $task->developer->fullname() }} @endisset</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div
                                                class="max-w-[150px] px-5 py-1 text-white text-sm font-semibold rounded {{ $this->getPriorityColor($task->priority) }}">
                                                {{ $this->getPriorityName($task->priority) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            {{ $task->getDate($task->due_date) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            {{ $task->getDate($task->completed_at) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="w-[250px]">

                                                <div class="text-xs text-start font-medium text-gray-700">
                                                    {{ $task->getProgressPercentage() }}%
                                                </div>
                                                {{-- barra di progresso --}}
                                                <div class="w-full bg-gray-200 rounded-full h-1.5">
                                                    <div class="h-1.5 rounded-full transition-all duration-500 {{ 
                                                        $task->getProgressPercentage() >= 100 ? 'bg-red-700' : 
                                                        ($task->getProgressPercentage() >= 90 ? 'bg-orange-500' : 
                                                        ($task->getProgressPercentage() >= 50 ? 'bg-gray-600' : 'bg-green-500')) 
                                                    }}"
                                                        style="width: {{ $task->getProgressPercentage() }}%">
                                                    </div>
                                                    <div class="text-xs font-medium text-gray-700">
                                                        {{ $task->getRemainingTime() }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="px-6 py-4 text-center text-gray-500">
                            Nessuna progetto presente
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
