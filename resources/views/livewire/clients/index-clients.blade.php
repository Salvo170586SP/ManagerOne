<div class="-mt-2">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-bold mb-5">Anagrafica Clienti</h2>
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
                    <span class="text-sm whitespace-nowrap me-2">Cerca per città:</span>
                    <x-select shadow placeholder="Seleziona una città"  wire:model.live="searchCity" :options="$clients"
                        option-label="city" option-value="city" />
                </div>

                <x-button icon="plus" black label="Aggiungi Cliente" class="font-bold w-[200px] h-[32px]" wire:navigate
                    href="/clients/create" />
            </div>
        </div>

        <x-card shadow="false" class="w-[350px] border my-5">
            <div class="flex justify-between">
                <div class="bg-slate-500 w-[50px] h-[50px] flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="white" class="size-7">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                </div>
                <div>
                    <div class="text-xl text-end font-bold">
                        {{$clients->count()}}
                    </div>
                    <div class="text-sm">
                        Numero Clienti
                    </div>
                </div>
            </div>
        </x-card>


        <div class="{{-- overflow-x-auto --}}">
            @if($clients->count() > 0)
            <table class="min-w-full divide-y border divide-gray-200">
                <thead>
                    <tr>
                        <th scope="col"
                            class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                            ID</th>
                        <th scope="col"
                            class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                            Nome
                            e Cognome</th>
                        <th scope="col"
                            class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                            Email
                        </th>
                        <th scope="col"
                            class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                            Telefono</th>
                        <th scope="col"
                            class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                            Città
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
                    @foreach($clients as $client)
                    <tr wire:key="client-{{$client->id}}">
                        <td class="px-6 py-4 whitespace-nowrap">id</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{$client->fullName()}}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{$client->email}}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{$client->phone}}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{$client->city}}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{$client->createDate()}}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex justify-center">
                                <x-button flat black icon="eye" wire:navigate href="/clients/{{$client->id}}" />
                                <x-button flat blue icon="pencil" wire:navigate href="/clients/{{$client->id}}/edit" />
                                <x-button flat red icon="trash"
                                    x-on:click="$openModal('simpleModal-{{$client->id}}')" />
                                <x-modal name="simpleModal-{{$client->id}}" blur="sm" align="center">
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
                                            Sei sicuro di eliminare definitivamente il cliente?
                                        </p>

                                        <x-slot name="footer" class="flex justify-end gap-x-4">
                                            <x-button black label="Annulla" x-on:click="close" />
                                            <x-button red label="Elimina" wire:click="deleteClient({{$client->id}})" />
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
                Non ci sono Clienti registrati
            </div>
            @endif
        </div>
    </div>
</div>