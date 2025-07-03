<div class="-mt-2">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-bold mb-5">Developers</h2>
        @if (session('message'))
            <div class="bg-gray-200 border dark:bg-[#474747] dark:border-0 mx-8 rounded relative mb-4">
                <span class="block p-5">{{ session('message') }}</span>
            </div>
        @endif
    </div>

    <div class="bg-white rounded-lg border border-gray-300 h-full h-[calc(100vh-13rem)] overflow-y-auto p-6">

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
                    <span class="text-sm whitespace-nowrap me-2">Cerca per città:</span>
                    <x-select shadow placeholder="Seleziona una città" wire:model.live="searchCity" :options="$cities" />
                </div>

                <x-button icon="plus" black label="Aggiungi Developer" class="font-bold w-[200px] h-[32px]"
                    wire:navigate href="/developers/create" />

            </div>
        </div>

        <div class="flex gap-3">
            <x-card shadow="false" class="w-[350px]  border border-gray-300 my-5">
                <div class="flex justify-between">
                    <div class="bg-slate-500 w-[50px] h-[50px] rounded-full flex justify-center items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="white" class="size-7">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-xl text-end font-bold">
                            {{ $numberDevs }}
                        </div>
                        <div class="text-sm">
                            Numero Developers
                        </div>
                    </div>
                </div>
            </x-card>
            <x-card shadow="false" class="w-[350px]  border border-gray-300 my-5">
                <div class="flex justify-between">
                    <div class="bg-blue-700 w-[50px] h-[50px] rounded-full flex justify-center items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="white" class="size-7">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-xl text-end font-bold">
                            {{ $numberPms }}
                        </div>
                        <div class="text-sm">
                            Numero Project Managers
                        </div>
                    </div>
                </div>
            </x-card>
        </div>



        @if ($developers->count() > 0)
            <div class="overflow-auto">


                <table @if ($pollCondition) wire:poll.2s @endif
                    class="min-w-full divide-y border divide-gray-200">
                    <thead>
                        <tr>
                            <th scope="col"
                                class="px-6 py-5 text-center text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                ID</th>
                            <th scope="col"
                                class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                Nome
                                e Cognome</th>
                            <th scope="col"
                                class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                Città
                            </th>
                            <th scope="col"
                                class="px-6 py-5 text-center text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                Sede
                            </th>
                            <th scope="col"
                                class="px-6 py-5 text-center text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                Grado in azienda
                            </th>
                            <th scope="col"
                                class="px-6 py-5 text-center text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                Categoria
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
                    <tbody class="bg-white divide-y text-sm divide-gray-200">
                        @foreach ($developers as $developer)
                            <tr wire:key="developer-{{ $developer->id }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($developer->IdDev)
                                        #DEV-{{ $developer->IdDev }}
                                    @else
                                        #DEV
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $developer->fullName() }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $developer->city }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if ($developer->workplace)
                                        <div
                                            class="rounded-full font-medium text-sm px-4 py-1 {{ $this->getColorWorkplace($developer->workplace) }}">
                                            {{ $this->getNameWorkplace($developer->workplace) }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if ($developer->level)
                                        <div
                                            class="rounded-full font-medium text-sm px-4 py-1 {{ $this->getColorLevel($developer->level) }}">
                                            {{ $this->getNameLevel($developer->level) }}
                                        </div>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if ($developer->category)
                                        <div
                                            class="rounded-full font-medium text-sm px-4 py-1 {{ $this->getColorCategory($developer->category) }}">
                                            {{ $this->getNameCategory($developer->category) }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $developer->createDate() }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex justify-center">
                                        <x-button flat black icon="eye" wire:navigate
                                            href="/developers/{{ $developer->id }}" />
                                        @role('super_admin')
                                            <x-button flat blue icon="pencil" wire:navigate
                                                href="/developers/{{ $developer->id }}/edit" />
                                            <x-button flat red icon="trash"
                                                x-on:click="$openModal('developers-{{ $developer->id }}')" />
                                            <x-modal name="developers-{{ $developer->id }}" blur="sm" align="center">
                                                <x-card shadow="xl">
                                                    <div
                                                        class="flex items-center justify-center py-2 bg-red-400 text-white rounded-md mb-2 text-xl">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="size-6 me-2">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                                        </svg>
                                                        Attenzione!
                                                    </div>
                                                    <p class="text-base">
                                                        Sei sicuro di eliminare definitivamente il developer?
                                                    </p>

                                                    <x-slot name="footer" class="flex justify-end gap-x-4 font-medium">
                                                        <x-button black label="Annulla" x-on:click="close" />
                                                        <x-button red label="Elimina"
                                                            wire:click="deleteDev({{ $developer->id }})" />
                                                    </x-slot>
                                                </x-card>
                                            </x-modal>
                                        @endrole
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="py-3">
                {{ $developers->links('vendor.pagination.tailwind') }}
            </div>
        @else
            <div class="text-center font-medium">
                Non ci sono developers registrati
            </div>
        @endif
    </div>
</div>
