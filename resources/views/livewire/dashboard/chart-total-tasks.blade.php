<div class="w-full flex items-center">
    <div class="w-full h-[350px] flex flex-col items-start bg-white rounded-lg border border-gray-300 p-4">
        <h3 class=" font-medium ">Tasks</h3>
        <small class="mb-2">*le prime 4</small>
        <div class="w-full flex justify-center">
            @if($projects->count() > 0)
            <x-select shadow wire:model.live="selectedProjectId" placeholder="Seleziona Progetto" id="Progetti"
                :options="$projects" option-label="name" option-value="id" />
            @endif
        </div>

        @if ($tasks->count() > 0)
        <div class="border rounded-lg w-full  mt-5 ">
            <table class="w-full">
                <thead class="border-b">
                    <th>Titolo</th>
                    <th>Assegnato a</th>
                </thead>
                <tbody>
                    @foreach ($tasks->take(5) as $task)
                    <tr wire:key="task-{{ $task->id }}-{{  str()->random(10) }}">
                        <td class="text-center p-2">{{ $task->title }}</td>
                        <td class="text-center p-2">{{ $task->developer->fullName() }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="w-full mt-10">
            <div class="text-center p-2 flex flex-col justify-center items-center italic text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-15">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M14.25 6.087c0-.355.186-.676.401-.959.221-.29.349-.634.349-1.003 0-1.036-1.007-1.875-2.25-1.875s-2.25.84-2.25 1.875c0 .369.128.713.349 1.003.215.283.401.604.401.959v0a.64.64 0 0 1-.657.643 48.39 48.39 0 0 1-4.163-.3c.186 1.613.293 3.25.315 4.907a.656.656 0 0 1-.658.663v0c-.355 0-.676-.186-.959-.401a1.647 1.647 0 0 0-1.003-.349c-1.036 0-1.875 1.007-1.875 2.25s.84 2.25 1.875 2.25c.369 0 .713-.128 1.003-.349.283-.215.604-.401.959-.401v0c.31 0 .555.26.532.57a48.039 48.039 0 0 1-.642 5.056c1.518.19 3.058.309 4.616.354a.64.64 0 0 0 .657-.643v0c0-.355-.186-.676-.401-.959a1.647 1.647 0 0 1-.349-1.003c0-1.035 1.008-1.875 2.25-1.875 1.243 0 2.25.84 2.25 1.875 0 .369-.128.713-.349 1.003-.215.283-.4.604-.4.959v0c0 .333.277.599.61.58a48.1 48.1 0 0 0 5.427-.63 48.05 48.05 0 0 0 .582-4.717.532.532 0 0 0-.533-.57v0c-.355 0-.676.186-.959.401-.29.221-.634.349-1.003.349-1.035 0-1.875-1.007-1.875-2.25s.84-2.25 1.875-2.25c.37 0 .713.128 1.003.349.283.215.604.401.96.401v0a.656.656 0 0 0 .658-.663 48.422 48.422 0 0 0-.37-5.36c-1.886.342-3.81.574-5.766.689a.578.578 0 0 1-.61-.58v0Z" />
                </svg>
                Nessuna tasks
            </div>
        </div>
        @endif
    </div>
</div>