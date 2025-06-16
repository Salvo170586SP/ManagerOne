<div class="-mt-2">
    <h2 class="text-xl font-bold mb-5">Dettagli Developer</h2>
    <div class="flex mx-auto text-black h-[calc(100vh-13rem)]">
        <div class="w-[350px] h-auto bg-white p-5 me-5 rounded">
            <div class="flex items-center justify-center">
                <figure class="w-[200px] h-[200px]">
                    <img class="w-full h-full rounded-lg border dark:border-[#505050] dark:bg-[#505050] object-cover object-top"
                        src="{{ isset($developer->img_url) ? asset('/storage/' . $developer->img_url) : 'https://static.thenounproject.com/png/261694-200.png' }}"
                        alt="{{ $developer->fullName() }}">
                </figure>
            </div>
            <div class="font-bold text-sm text-center uppercase my-5">
                {{ $developer->fullName() }}
            </div>
            <div class="mb-4">
                <div class="font-medium text-sm">Email:</div>
                <div class="text-sm">
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
                <div class="font-medium text-sm">Ruolo:</div>
                @if ($developer->type)
                    <div
                        class="rounded text-white max-w-[150px] text-center text-sm  font-medium {{ $this->getColorType($developer->type) }}">
                        {{ $this->getNameType($developer->type) }}
                    </div>
                @endif
            </div>
            <div class="mb-4">
                <div class="font-medium text-sm">Grado In Azienda:</div>
                @if ($developer->level)
                    <div
                        class="rounded text-white max-w-[150px] text-center text-sm font-medium {{ $this->getColorLevel($developer->level) }}">
                        {{ $this->getNameLevel($developer->level) }}
                    </div>
                @endif
            </div>
            <div class="mb-4">
                <div class="font-medium text-sm">Categoria:</div>
                @if ($developer->category)
                    <div
                        class="rounded text-white max-w-[150px] text-center text-sm  font-medium {{ $this->getColorCategory($developer->category) }}">
                        {{ $this->getNameCategory($developer->category) }}
                    </div>
                @endif
            </div>
            <div class="mb-4">
                <div class="font-medium text-sm">Sede:</div>
                @if ($developer->workplace)
                    <div
                        class="rounded text-white max-w-[150px] text-center text-sm  font-medium {{ $this->getColorWorkplace($developer->workplace) }}">
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

        <div class="w-full  p-6 bg-white rounded">
            <div class="w-full flex justify-end mb-5 pb-5">
                <x-button icon="arrow-left" black label="Torna ai Developers" class="font-bold w-[200px] h-[32px]"
                    wire:navigate href="/developers" />
            </div>

            <h3 class="font-bold text-lg uppercase">Tasks</h3>
            <x-card shadow="false" class="w-[350px] border my-5">
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


            <div class="overflow-x-auto">
                @if ($developer->tasks->count() > 0)
                    <table class="min-w-full divide-y border divide-gray-200">
                        <thead>
                            <tr>
                                <th scope="col"
                                    class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                    Titolo</th>
                                <th scope="col"
                                    class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                    Priorità</th>
                                <th scope="col"
                                    class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                    Stato</th>
                                <th scope="col"
                                    class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                    Scadenza</th>
                                <th scope="col"
                                    class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                    Chiusura Task</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($developer->tasks as $task)
                                <tr wire:key="task-{{ $task->id }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $task->title }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div
                                            class="rounded text-white max-w-[150px] py-1 text-center text-sm font-medium {{ $this->getColorPriorityTask($task->priority) }}">
                                            {{ $this->getPriorityName($task->priority) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div
                                            class="rounded text-white max-w-[150px] py-1 text-center text-sm font-medium {{ $this->getColorStatusTask($task->status) }}">
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
                                        <input class="border border-gray-300 px-5 bg-gray-50 rounded"  wire:model="taskDates.{{ $task->id }}" wire:change.live="changeDate({{ $task->id }})" type="datetime-local" id="completed_at-{{ $task->id }}" />

                                       {{--  @if ($task->completed_at)
                                            {{ $task->getDate($task->completed_at) }}
                                        @else
                                            -
                                        @endif --}}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <x-button flat gray icon="eye"
                                            x-on:click="$openModal('tasks-{{ $task->id }}')" />
                                        <x-modal name="tasks-{{ $task->id }}" blur="sm" align="center">
                                            <x-card shadow="xl" class="max-w-[700px]">
                                                <div class="p-2 bg-gray-300 text-white rounded-md mb-2 text-xl">
                                                    Descrizione Task
                                                </div>
                                                <p class="text-sm p-2 break-words break-all whitespace-pre-wrap">
                                                    {{ $task->description }}
                                                </p>

                                                <x-slot name="footer" class="flex justify-end gap-x-4">
                                                    <x-button black label="Annulla" x-on:click="close" />

                                                </x-slot>
                                            </x-card>
                                        </x-modal>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="px-6 py-4 text-center text-gray-500">
                        Nessuna task presente
                    </div>
                @endif
            </div>

        </div>
    </div>
