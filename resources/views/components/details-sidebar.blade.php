@props(['show' => false, 'item' => null, 'onClose'])
<div>


    <div x-data="{ open: @entangle($attributes->wire('model')) }" x-show="open" x-cloak x-transition:enter="transform transition ease-in-out duration-200"
        x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
        x-transition:leave="transform transition ease-in-out duration-200" x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="fixed inset-y-0 right-0 z-50 w-96 bg-white shadow-xl border-l border-gray-200 overflow-y-auto">

        <div class="flex items-center justify-between p-6 border-b border-gray-200">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                      </svg>
                      
                    Dettagli
                </h3>
            </div>
            <button wire:click="{{ $onClose }}" class="text-gray-400 hover:text-gray-600 cursor-pointer">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        <div class="p-6">
            @if ($item)
                <div class="space-y-6">
                    <div class="flex flex-col items-center">
                        <figure class="w-24 h-24 border border-gray-200 rounded-full bg-white">
                            <img src="{{ $item->img_url ? asset('storage/' . $item->img_url) : 'https://static.thenounproject.com/png/261694-200.png' }}"
                                alt="{{ $item->fullName() }}" class="object-cover w-full h-full rounded-full">
                        </figure>

                        <div class="text-center mt-4">
                            <h4 class="text-xl font-bold text-gray-800">{{ $item->fullName() }}</h4>
                            <p class="text-sm text-gray-500">{{ $item->email }}</p>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-6">
                        <dl class="space-y-4">
                            <div class="flex justify-between items-center">
                                <dt class="text-sm font-medium text-gray-500">Ruolo</dt>
                                <dd class="text-sm text-gray-900 font-semibold bg-gray-100 px-2 py-1 rounded-md">
                                    {{ $item->roles->first()->name ?? 'N/A' }}</dd>
                            </div>
                            <div class="flex justify-between items-center">
                                <dt class="text-sm font-medium text-gray-500">Membro dal</dt>
                                <dd class="text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</dd>
                            </div>
                            <div class="flex justify-between items-center">
                                <dt class="text-sm font-medium text-gray-500">Pagina dell'utente</dt>
                                <x-button wire:navigate href="/developers/{{ $item->id }}" icon="eye" black flat title="Pagina utente" />
                            </div>
                            {{-- Aggiungi qui altri dettagli se necessario --}}
                        </dl>
                    </div>
                </div>
            @else
                <div class="text-center text-gray-500 py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="mt-4">Seleziona una chat per vedere i dettagli.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Overlay per chiudere la sidebar -->
    <div x-data="{ open: @entangle($attributes->wire('model')) }" x-show="open" x-cloak x-transition:enter="transition-opacity ease-linear duration-200"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" class="fixed inset-0 z-40 bg-black/30 bg-opacity-50"
        wire:click="{{ $onClose }}">
    </div>
