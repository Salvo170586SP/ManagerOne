<div class="-mt-2">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-bold mb-5">Progetti</h2>
        @if (session('message'))
        <div class="bg-gray-200 border dark:bg-[#474747] dark:border-0 mx-8 rounded relative mb-4">
            <span class="block p-5">{{ session('message') }}</span>
        </div>
        @endif
    </div>

    <div class="bg-white rounded h-[calc(100vh-13rem)] overflow-y-auto p-6">
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

                <div class="me-5 h-[32px] flex justify-between items-center">
                    <span class="text-sm whitespace-nowrap me-2">Cerca per stato:</span>
                    <x-select shadow="false" placeholder="Seleziona Stato" wire:model.live="searchAvailable" :options="[
                        ['label' => 'Approvato', 'value' => 1],
                        ['label' => 'Da Approvare', 'value' => 0]]" option-label="label" option-value="value" />
                </div>

                <x-button icon="plus" black label="Aggiungi Progetto" class="font-bold w-[200px] h-[32px]" wire:navigate
                    href="/projects/create" />
            </div>
        </div>

        <x-card shadow="false" class="w-[350px] border my-5">
            <div class="flex justify-between">
                <div class="bg-slate-500 w-[50px] h-[50px] flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="white" class="size-7">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5m.75-9 3-3 2.148 2.148A12.061 12.061 0 0 1 16.5 7.605" />
                    </svg>
                </div>
                <div>
                    <div class="text-xl text-end font-bold">
                        {{$projects->count()}}
                    </div>
                    <div class="text-sm">
                        Numero Progetti
                    </div>
                </div>
            </div>
        </x-card>


        <div class="{{-- overflow-x-auto --}}">
            @if($projects->count() > 0)
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
                            class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                            Data
                            Creazione</th>
                        <th scope="col"
                            class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($projects as $project)
                    <tr wire:key="project-{{$project->id}}">
                        <td class="px-6 py-4 text-center whitespace-nowrap">id</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{$project->name}}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{$project->client->fullName()}}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{$project->preventive}} €</td>
                        <td class="px-6 py-4 flex justify-center text-center whitespace-nowrap">
                            @if($project->is_available)
                            <div class="bg-green-600 rounded-full text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                                </svg>
                            </div>
                            @else
                            <div class="bg-red-600 rounded-full text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{$project->createDate()}}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex justify-center">
                                <x-button flat black icon="eye" wire:navigate href="/projects/{{$project->id}}" />
                                <x-button flat gray icon="pencil" wire:navigate
                                    href="/projects/{{$project->id}}/edit" />
                                <x-button flat red icon="trash"
                                    x-on:click="$openModal('simpleModal-{{$project->id}}')" />
                                <x-modal name="simpleModal-{{$project->id}}" blur="sm" align="center">
                                    <x-card shadow="xl">
                                        <div
                                            class="flex items-center justify-center py-2 bg-red-400 text-white rounded-md mb-2 text-xl">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6 me-2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                            </svg>
                                            Attenzione!
                                        </div>
                                        <p class="font-semubold text-lg">
                                            Sei sicuro di eliminare definitivamente il progetto?
                                        </p>

                                        <x-slot name="footer" class="flex justify-end gap-x-4">
                                            <x-button black label="Annulla" x-on:click="close" />
                                            <x-button red label="Elimina"
                                                wire:click="deleteProject({{$project->id}})" />
                                        </x-slot>
                                    </x-card>
                                </x-modal>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="text-center font-medium">
                Non ci sono Progetti registrati
            </div>
            @endif
        </div>
    </div>
</div>