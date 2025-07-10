<div class="-mt-2 min-h-screen overflow-x-hidden">
    <h2 class="text-xl font-bold mb-5">Dettagli Developer</h2>
    <div class="flex flex-wrap w-full mx-auto text-black h-screen   h-[calc(100vh-13rem)]">
        <div class="w-full max-w-[250px] h-auto bg-white p-5 me-5 rounded-lg border border-gray-300 break-words">
            <div class="flex items-center justify-center">
                @isset($developer->img_url)
                    <figure class="w-[100px] h-[100px]">
                        <img class="w-full h-full rounded-full border dark:border-[#505050] dark:bg-[#505050] object-cover object-top"
                            src="{{ asset('storage/' . $developer->img_url) }}" alt="{{ $developer->fullName() }}">
                    </figure>
                @else
                    <div
                        class="w-[100px] h-[100px] border rounded-full bg-white overflow-hidden flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-7">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                    </div>
                @endisset
            </div>
            <div class="font-bold text-sm text-center uppercase my-5 border-b pb-3">
                {{ $developer->fullName() }}
            </div>
            <div class="mb-4">
                <div class="font-medium text-sm">ID:</div>
                <div class="text-sm">
                    @if ($developer->IdDev)
                        #DEV-{{ $developer->IdDev }}
                    @else
                        #DEV
                    @endif
                </div>
            </div>
            <div class="mb-4">
                <div class="font-medium text-sm">Email:</div>
                <div class="text-sm whitespace-normal break-words max-w-[180px]">
                    {{ $developer->email ?? '-' }}
                </div>
            </div>
            <div class="mb-4">
                <div class="font-medium text-sm">Telefono:</div>
                <div class="text-sm">
                    {{ $developer->phone ?? '-' }}</div>
            </div>

            <div class="mb-4">
                <div class="font-medium text-sm">Città:</div>
                <div class="text-sm">
                    {{ $developer->city ?? '-' }}
                </div>
            </div>
            <hr class="my-5">
            <div class="mb-4">
                <div class="font-medium text-sm mb-1">Ruolo:</div>
                @if ($developer->type)
                    <div
                        class="rounded-full max-w-[150px] text-center text-sm py-1 font-medium {{ $this->getColorType($developer->type) }}">
                        {{ $this->getNameType($developer->type) }}
                    </div>
                @endif
            </div>
            <div class="mb-4">
                <div class="font-medium text-sm mb-1">Grado In Azienda:</div>
                @if ($developer->level)
                    <div
                        class="rounded-full   max-w-[150px] text-center py-1 text-sm font-medium {{ $this->getColorLevel($developer->level) }}">
                        {{ $this->getNameLevel($developer->level) }}
                    </div>
                @endif
            </div>
            <div class="mb-4">
                <div class="font-medium text-sm mb-1">Categoria:</div>
                @if ($developer->category)
                    <div
                        class="rounded-full  max-w-[150px] text-center text-sm py-1 font-medium {{ $this->getColorCategory($developer->category) }}">
                        {{ $this->getNameCategory($developer->category) }}
                    </div>
                @endif
            </div>
            <div class="mb-4">
                <div class="font-medium text-sm mb-1">Sede:</div>
                @if ($developer->workplace)
                    <div
                        class="rounded-full max-w-[150px] text-center text-sm py-1 font-medium {{ $this->getColorWorkplace($developer->workplace) }}">
                        {{ $this->getNameWorkplace($developer->workplace) }}
                    </div>
                @endif
            </div>
            <div class="mb-4">
                <div class="font-medium text-sm mb-2">Team assegnato/i:</div>
                @foreach ($developer->teams as $team)
                    {{ $team->name }}
                @endforeach
            </div>
        </div>

        <div class="flex-1 min-w-0 p-6 bg-white rounded-lg border border-gray-300">
            <div class="w-full flex justify-between items-center mb-5 pb-5">
                <h3 class="font-bold text-lg uppercase">Tasks</h3>
                <x-button icon="arrow-left" black label="Torna ai Developers" class="font-bold w-[200px] h-[32px]"
                    wire:navigate href="/developers" />
            </div>

            <x-card shadow="false" class="w-[350px] border border-gray-300 my-5">
                <div class="flex justify-between">
                    <div class="bg-slate-500 w-[50px] h-[50px] flex rounded-full justify-center items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="white" class="size-7">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5m.75-9 3-3 2.148 2.148A12.061 12.061 0 0 1 16.5 7.605" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-xl text-end font-bold">
                            {{ $developer->tasks->count() }}
                        </div>
                        <div class="text-sm">
                            Numero Tasks Assegnate
                        </div>
                    </div>
                </div>
            </x-card>


            @if ($developer->tasks->count() > 0)
                <div class="w-full overflow-x-auto">
                    <table class="w-full divide-y border divide-gray-200 ">
                        <thead>
                            <tr>
                                <th scope="col"
                                    class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                    Titolo</th>
                                <th scope="col"
                                    class="px-6 py-5 text-cenetr text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                    Priorità</th>
                                <th scope="col"
                                    class="px-6 py-5 text-cenetr text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                    Stato</th>
                                <th scope="col"
                                    class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                    Scadenza</th>
                                <th scope="col"
                                    class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                    Chiusura Task</th>
                                <th scope="col"
                                    class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                    Descrizione</th>
                                <th scope="col"
                                    class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                    Note</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y text-sm divide-gray-200">
                            @foreach ($developer->tasks as $task)
                                <tr wire:key="task-{{ $task->id }}-{{  str()->random(10) }}">
                                    <td class="px-6 py-4 whitespace-normal break-words max-w-[200px]">
                                        {{ \Illuminate\Support\Str::limit($task->title, 10) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div
                                            class="rounded text-white max-w-[150px] py-1 text-center text-sm font-medium {{ $this->getColorPriorityTask($task->priority) }}">
                                            {{ $this->getPriorityName($task->priority) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div
                                            class="rounded text-white w-[130px] py-1 text-center text-sm font-medium {{ $this->getColorStatusTask($task->status) }}">
                                            {{ $this->getStatusNameTask($task->status) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($task->due_date)
                                            {{ $task->getDate($task->due_date) }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <x-datetime-picker without-time wire:model.live="taskDates.{{ $task->id }}"
                                            id="completed_at-{{ $task->id }}" shadow />
                                    </td>
                                    <td class="px-6 py-4 whitespace-normal break-words max-w-[200px] text-center">
                                        <x-button flat gray icon="eye"
                                            x-on:click="$openModal('tasks-{{ $task->id }}')" />
                                        <x-modal name="tasks-{{ $task->id }}" blur="sm" align="center">
                                            <x-card shadow="xl" class="max-w-[700px]">
                                                <p class="text-base break-words">
                                                    @if ($task->description)
                                                        {{ $task->description }}
                                                    @else
                                                        Nessuna descrizione
                                                    @endif
                                                </p>
                                                <x-slot name="footer" class="flex justify-end gap-x-4">
                                                    <x-button black label="Annulla" x-on:click="close" />
                                                </x-slot>
                                            </x-card>
                                        </x-modal>
                                    </td>
                                    <td class="px-6 py-4 whitespace-normal break-words max-w-[120px] text-center">
                                        <div class="relative">
                                            <x-button flat blue icon="document-text"
                                                wire:click="openNotesSidebar({{ $task->id }})"
                                                title="Visualizza Note" />
                                            <div
                                                class="absolute right-2 top-0  rounded-full bg-blue-500 h-[15px] w-[15px] text-center text-xs font-bold text-white">
                                                {{ $task->notes->count() }}</div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-6 py-4 text-center text-gray-500">
                    Nessuna task presente
                </div>
            @endif

        </div>
        <!-- Componente Sidebar per le Note -->
        <x-notes-sidebar wire:model="showDrawer2" :notes="$selectedTaskNotes" :item="$selectedTask" :edit-note-id="$editNoteId"
            onClose="closeNotesSidebar" />
    </div>
</div>
