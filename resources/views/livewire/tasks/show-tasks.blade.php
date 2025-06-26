<div class="-mt-2">
    <h2 class="text-xl font-bold mb-5">Dettagli Tasks</h2>
    <div class="flex mx-auto text-black w-full">

        <div class="w-[300px] max-h-[400px] bg-white p-5 me-5 rounded">
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

        <div class="w-full min-w-0">
            <div class="mb-5 flex items-center p-6 bg-white rounded h-full">
                <div class="text-sm w-full h-full">
                    <div class="flex justify-between items-center mb-5">
                        <h3 class="font-bold text-xl ">Tasks</h3>
                        <x-button icon="arrow-left" black label="Torna ai Tasks" class="font-bold w-[200px] h-[32px]"
                            wire:navigate href="/tasks" />
                    </div>

                    @if ($tasks->count() > 0)
                        <div class="overflow-x-auto py-5">
                            <table class="min-w-full border divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th scope="col"
                                            class="py-5 text-center text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                            Task</th>
                                        <th scope="col"
                                            class="py-5 text-center text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                            Assegnato a
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-5 text-center text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                            Priorità
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-5 text-center text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                            Stato
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-5 text-center text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                            Note
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-5 text-center text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                            Scadenza
                                        </th>
                                        <th scope="col"
                                            class="px-3 text-center py-5 text-center text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                            Chiusura Task
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-5 text-center text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                            Progressione
                                        </th>
                                        @role('super_admin')
                                        <th scope="col"
                                            class="px-6 py-5 text-center text-xs font-medium border text-gray-500 uppercase tracking-wider">

                                        </th>
                                        @endrole
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y text-sm divide-gray-200">
                                    @foreach ($tasks as $task)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm">{{ \Illuminate\Support\Str::limit($task->title, 10) }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm">
                                                    @isset($task->developer)
                                                        {{ $task->developer->fullname() }}
                                                    @endisset
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <div
                                                    class="max-w-[150px] px-5 py-1 text-white text-sm font-semibold rounded {{ $this->getPriorityColor($task->priority) }}">
                                                    {{ $this->getPriorityName($task->priority) }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <div
                                                    class="max-w-[150px] px-5 py-1 text-white text-sm font-semibold rounded {{ $this->getStatusColor($task->status) }}">
                                                    {{ $this->getStatusName($task->status) }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <div class="relative">
                                                    <x-button flat blue icon="document-text"
                                                        wire:click="openNotesSidebar({{ $task->id }})"
                                                        title="Visualizza Note" />
                                                    <div
                                                        class="absolute right-2 top-0  rounded-full bg-blue-500 h-[15px] w-[15px] text-center text-xs font-bold text-white">
                                                        {{ $task->notes->count() }}</div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                {{ $task->getDate($task->due_date) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                {{ $task->getDate($task->completed_at) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="w-[220px]">
                                                    <div class="text-xs text-start font-medium text-gray-700">
                                                        {{ $task->getProgressPercentage() }}%
                                                    </div>
                                                    {{-- barra di progresso --}}
                                                    <div class="w-full bg-gray-200 rounded-full h-1.5">
                                                        <div class="h-1.5 rounded-full transition-all duration-500 {{ $task->getProgressPercentage() >= 100
                                                            ? 'bg-red-700'
                                                            : ($task->getProgressPercentage() >= 90
                                                                ? 'bg-orange-500'
                                                                : ($task->getProgressPercentage() >= 50
                                                                    ? 'bg-gray-600'
                                                                    : 'bg-green-500')) }}"
                                                            style="width: {{ $task->getProgressPercentage() }}%">
                                                        </div>
                                                        <div class="text-xs font-medium text-gray-700">
                                                            {{ $task->getRemainingTime() }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            @role('super_admin')
                                            <td class="px-6 py-2 whitespace-nowrap">
                                                <x-button flat blue icon="pencil" wire:navigate
                                                    href="/tasks/{{ $task->id }}/{{ $project->id }}/edit" />
                                                <x-button flat red icon="trash"
                                                    x-on:click="$openModal('simpleModalTasks-{{ $task->id }}')" />
                                                <x-modal name="simpleModalTasks-{{ $task->id }}" blur="sm"
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
                                                            Sei sicuro di eliminare definitivamente la task?
                                                        </p>

                                                        <x-slot name="footer" class="flex justify-end gap-x-4">
                                                            <x-button black label="Annulla" x-on:click="close" />
                                                            <x-button red label="Elimina"
                                                                wire:click="deleteTask({{ $task->id }})" />
                                                        </x-slot>
                                                    </x-card>
                                                </x-modal>
                                            </td>
                                            @endrole
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="py-3">
                            {{ $tasks->links('vendor.pagination.tailwind') }}
                        </div>
                        @else
                        <div class="px-6 py-4 text-center text-gray-500">
                            Nessuna tasks presente
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <!-- Componente Sidebar per le Note -->
    <x-notes-sidebar wire:model="showDrawer2" :notes="$selectedTaskNotes" :item="$selectedTask" :edit-note-id="$editNoteId"
        onClose="closeNotesSidebar" />
</div>
