<div class="-mt-2 relative" x-data="{ isOpen: true }">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-bold mb-5">Archivio Documenti</h2>
    </div>

    <div class="bg-white rounded-lg border border-gray-300 h-[calc(100vh-13rem)] overflow-y-auto p-6">
        @role('super_admin')
            <div class="flex justify-between items-center">
                <div class="w-[350px] h-[32px]">
                    <x-input type="search" wire:model.live="search" placeholder="Cerca.." shadow="false" />
                </div>


                <div class="flex justify-between items-center">
                    <div class="w-[350px] me-5">
                        <x-select wire:model.live="searchType" :options="[
                            ['value' => 'client', 'label' => 'Clienti'],
                            ['value' => 'developer', 'label' => 'Developers'],
                            ['value' => 'project_manager', 'label' => 'Project Managers'],
                        ]" option-label="label" option-value="value"
                            placeholder="Cerca per tipo" shadow />
                    </div>
                    <div class="me-5 h-[32px] flex justify-between items-center">
                        <span class="text-sm whitespace-nowrap me-2">Data creazione:</span>
                        <x-datetime-picker without-time wire:model.live="searchDate" placeholder="Cerca per data"
                            shadow="false" />
                    </div>
                </div>
            </div>
            <div class="flex gap-3">
                <x-card shadow="false" class="w-[350px] border border-gray-300 my-5">
                    <div class="flex justify-between">
                        <div class="bg-slate-500 w-[50px] h-[50px] rounded-full flex justify-center items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="white" class="size-7">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-xl text-end font-bold">
                                {{ $clients->count() }}
                            </div>
                            <div class="text-sm">
                                Numero Archivi Clienti
                            </div>
                        </div>
                    </div>
                </x-card>
                <x-card shadow="false" class="w-[350px] border border-gray-300 my-5">
                    <div class="flex justify-between">
                        <div class="bg-slate-500 w-[50px] h-[50px] rounded-full flex justify-center items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="white" class="size-7">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-xl text-end font-bold">
                                {{ $developers->count() }}
                            </div>
                            <div class="text-sm">
                                Numero Archivi Developers
                            </div>
                        </div>
                    </div>
                </x-card>
                <x-card shadow="false" class="w-[350px] rounded-lg border border-gray-300 my-5">
                    <div class="flex justify-between">
                        <div class="bg-slate-500 w-[50px] h-[50px] rounded-full flex justify-center items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="white" class="size-7">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-xl text-end font-bold">
                                {{ $pms->count() }}
                            </div>
                            <div class="text-sm">
                                Numero Archivi Project Managers
                            </div>
                        </div>
                    </div>
                </x-card>
            </div>
        @endrole

        @php
            use Illuminate\Support\Facades\Auth;
            $user = Auth::user();
        @endphp

        @if ($user && $user->type === 'developer')
            <h2 class="font-bold text-lg mt-5">I Miei Documenti</h2>
            <div class="flex flex-wrap gap-3 mt-8 pb-5">
                @forelse ($developers as $developer)
                    <x-card wire:key="docDevAuth-{{ $developer->id }}-{{  str()->random(10) }}" shadow
                        class="border w-[300px] bg-blue-50/50 cursor-pointer" wire:navigate
                        href="/documents/{{ $developer->id }}">
                        <div class="flex items-center justify-center h-[100px] border-b ">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-21">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                            </svg>
                        </div>
                        <div class="flex items-center justify-between mt-2">
                            <div class="font-bold text-xs">{{ $developer->fullName() }}</div>
                        </div>
                        <div class="text-xs mb-1">
                            <small class="font-semibold">Creato il:</small>
                            {{ $developer->created_at ? $developer->created_at : '-' }}
                        </div>
                    </x-card>
                @empty
                    <div class="text-sm text-center font-medium italic text-gray-400">Non ci sono documenti</div>
                @endforelse
            </div>
        @else
            @if (!$searchType || $searchType === 'client')
                <h2 class="font-bold text-lg mt-5">Archivio Clienti</h2>
                <div class="flex flex-wrap gap-3 mt-8 pb-5">
                    @forelse ($clients as $client)
                        <x-card wire:key="docCl-{{ $client->id }}-{{  str()->random(10) }}" shadow
                            class="rounded-lg border border-gray-300 w-[300px] bg-blue-50/50 cursor-pointer" wire:navigate
                            href="/documents/{{ $client->id }}">
                            <div class="flex items-center justify-center h-[100px] border-b ">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-21">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                                </svg>
                            </div>
                            <div class="flex items-center justify-between mt-2">
                                <div class="font-bold text-xs">{{ $client->fullName() }}</div>
                            </div>
                            <div class="text-xs mb-1">
                                <small class="font-semibold">Creato il:</small>
                                {{ $client->created_at ? $client->created_at : '-' }}
                            </div>
                        </x-card>
                    @empty
                        <div class="text-sm text-center font-medium italic text-gray-400">Non ci sono documenti</div>
                    @endforelse
                </div>
            @endif
            @if (!$searchType || $searchType === 'developer')
                <h2 class="font-bold text-lg mt-5">Archivio Developers</h2>
                <div class="flex flex-wrap gap-3 mt-8 pb-5">
                    @forelse ($developers as $developer)
                        <x-card wire:key="docDev-{{ $developer->id }}-{{  str()->random(10) }}" shadow
                            class="rounded-lg border border-gray-300 w-[300px] bg-blue-50/50 cursor-pointer" wire:navigate
                            href="/documents/{{ $developer->id }}">
                            <div class="flex items-center justify-center h-[100px] border-b ">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-21">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                                </svg>
                            </div>
                            <div class="flex items-center justify-between mt-2">
                                <div class="font-bold text-xs">{{ $developer->fullName() }}</div>
                            </div>
                            <div class="text-xs mb-1">
                                <small class="font-semibold">Creato il:</small>
                                {{ $developer->created_at ? $developer->created_at : '-' }}
                            </div>
                        </x-card>
                    @empty
                        <div class="text-sm text-center font-medium italic text-gray-400">Non ci sono documenti</div>
                    @endforelse
                </div>
            @endif
            @if (!$searchType || $searchType === 'project_manager')
                <h2 class="font-bold text-lg mt-5">Archivio Project Managers</h2>
                <div class="flex flex-wrap gap-3 mt-8 pb-5">
                    @forelse ($pms as $pm)
                        <x-card wire:key="docPm-{{ $pm->id }}-{{  str()->random(10) }}" shadow
                            class="rounded-lg border border-gray-300 w-[300px] bg-blue-50/50 cursor-pointer" wire:navigate
                            href="/documents/{{ $pm->id }}">
                            <div class="flex items-center justify-center h-[100px] border-b ">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-21">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                                </svg>
                            </div>
                            <div class="flex items-center justify-between mt-2">
                                <div class="font-bold text-xs">{{ $pm->fullName() }}</div>
                            </div>
                            <div class="text-xs mb-1">
                                <small class="font-semibold">Creato il:</small>
                                {{ $pm->created_at ? $pm->created_at : '-' }}
                            </div>
                        </x-card>
                    @empty
                        <div class="text-sm text-center font-medium italic text-gray-400">Non ci sono documenti</div>
                    @endforelse
                </div>
            @endif
        @endif
    </div>
</div>
