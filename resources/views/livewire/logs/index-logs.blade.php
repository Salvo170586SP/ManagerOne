<div class="-mt-2 w-full">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-bold mb-5">Logs</h2>
        @if (session('message'))
            <div class="bg-gray-200 border dark:bg-[#474747] dark:border-0 mx-8 rounded relative mb-4">
                <span class="block p-5">{{ session('message') }}</span>
            </div>
        @endif
    </div>

    <div class="w-full bg-white rounded h-[calc(100vh-13rem)] overflow-y-auto p-6">

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
            </div>
        </div>

        <x-card shadow="false" class="w-[350px]  border  my-5">
            <div class="flex justify-between">
                <div class="bg-yellow-500 w-[50px] h-[50px] rounded-full flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="white" class="size-7">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                    </svg>

                </div>
                <div>
                    <div class="text-xl text-end font-bold">
                        {{ count($logs) }}
                    </div>
                    <div class="text-sm">
                        Totale Logs
                    </div>
                </div>
            </div>
        </x-card>


        <div class="overflow-x-auto w-full">
            <div class="text-end w-full mb-5">
                <x-button red label="Svuota Log" x-on:click="$openModal('simpleModalLog')" />
                <x-modal name="simpleModalLog" blur="sm" align="center">
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
                            Sei sicuro di eliminare svuotare la console dei log?
                        </p>

                        <x-slot name="footer" class="flex justify-end gap-x-4">
                            <x-button black label="Annulla" x-on:click="close" />
                            <x-button red label="Elimina" wire:click="deleteLog" />
                        </x-slot>
                    </x-card>
                </x-modal>
            </div>
            <div class="w-full h-120 border border-gray-300 bg-gray-100 text-gray-700 p-3 rounded-lg overflow-x-auto">
                <ul class="w-full">
                    @if (count($logs) > 0)
                        @foreach ($logs as $log)
                            <li class="w-full">
                                <div class="flex items-center gap-2 mb-2">
                                    -
                                    <div class="w-full rounded py-3 px-2 font-mono text-xs break-all">
                                        {{ $log }}
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    @else
                        <div class="text-center font-medium">
                            Non ci sono logs registrati
                        </div>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
