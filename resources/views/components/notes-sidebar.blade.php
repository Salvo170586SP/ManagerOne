@props(['show' => false, 'notes' => [], 'item' => null, 'onClose', 'editNoteId' => null])
<div>

    <div x-data="{ open: @entangle($attributes->wire('model')) }" x-show="open" x-cloak x-transition:enter="transform transition ease-in-out duration-200"
        x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
        x-transition:leave="transform transition ease-in-out duration-200" x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="fixed inset-y-0 right-0 z-50 w-96 bg-white shadow-xl border-l border-gray-200 overflow-y-auto">

        <div class="flex items-center justify-between p-6 border-b border-gray-200">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">
                    Note  
                    @if ($item)
                        {{ $item->name }}
                    @endif
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
            <div x-data="{ openForm: false }" x-on:note-added.window="openForm = false">
                <div class="flex justify-center">
                    <x-button @click="openForm = !openForm" x-show="openForm == false" icon="plus" blue
                        class="font-bold w-[200px] h-[32px]" />

                    <x-button @click="openForm = !openForm" x-show="openForm == true" icon="minus" gray
                        class="font-bold w-[200px] h-[32px]" />
                </div>

                <div x-show="openForm == true" class="mt-10 flex flex-col items-end border rounded p-5">
                    <div>
                        <x-input wire:model="newNoteTitle" label="Titolo" shadow
                            placeholder="Inserisci il titolo della nota" />
                        <x-textarea wire:model="newNoteDescription" class="mt-2" label="Descrizione" shadow
                            placeholder="Inserisci la descrizione della nota" />
                        <x-input type="file" shadow wire:model="url_file" label="Allega" class="font-bold w-[100px] mt-2" />
                    </div>
                    @if ($item)
                        <x-button wire:click="addNote({{ $item->id }})" gray
                            label="Aggiungi" class="font-bold w-[100px] h-[32px] mt-3" />
                    @endif
                </div>
            </div>

            @if ($notes && count($notes) > 0)
                <div class="space-y-4 mt-10">
                    @foreach ($notes as $note)
                        <div wire:key="note-item-{{ $item->id }}-{{ $note->id }}{{-- -{{  str()->random(10) }} --}}"
                            class="@if ($note->is_true) bg-blue-50 @else bg-gray-50 @endif rounded-lg p-3 border border-gray-200">

                            <div @if ($editNoteId !== $note->id) @else style="display:none" @endif>
                                <div class="flex items-start justify-between mb-2">
                                    <h4 class="font-medium text-gray-900 text-sm"
                                        style="overflow-wrap: break-word; word-break: break-word;">
                                        {{ \Illuminate\Support\Str::limit($note->title, 10) }}</h4>
                                    <span
                                        class="text-xs text-gray-500 ms-10">{{ $note->getDate($note->created_at) }}</span>
                                </div>
                                <p class="text-sm text-gray-700 mt-5"
                                    style="overflow-wrap: break-word; word-break: break-word;">
                                    {{ $note->description }}</p>
                                <div class="flex items-center justify-between text-xs text-gray-500">
                                    <span>Creato da: {{ $note->admin->name ?? 'N/A' }}</span>
                                    <button wire:click="toggleImportant({{ $note->id }})"
                                        class="bg-blue-50 px-2 py-1 rounded-full cursor-pointer font-bold">
                                        <div
                                            class="@if ($note->is_true == false) text-blue-500 @else text-yellow-500 @endif">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                                            </svg>
                                        </div>
                                    </button>
                                </div>
                            </div>

                            <div @if ($editNoteId === $note->id) @else style="display:none" @endif>
                                <h3 class="font-semibold text-sm mb-2">Modifica Nota</h3>

                                <div>
                                    <x-input wire:model="editNoteTitle" label="Titolo" shadow
                                        placeholder="Inserisci il titolo della nota" />
                                    <x-textarea  shadow wire:model="editNoteDescription" class="mt-2" label="Descrizione"
                                        placeholder="Inserisci la descrizione della nota" />
                                    <x-input shadow type="file" wire:model="url_file" label="Allega"
                                        class="font-bold w-[100px] mt-2" />
                                </div>
                                <div class="flex gap-2 mt-3">
                                    <x-button wire:click="updateNote({{ $note->id }})" blue label="Modifica"
                                        class="font-bold" />
                                    <x-button wire:click="cancelEdit" gray label="Cancella" class="font-bold" />
                                </div>
                            </div>

                            @if ($note->url_file)
                            <hr class="my-3">
                                <span class="text-xs text-gray-500">Allegato:</span>
                                <div class="mt-3 flex gap-2 items-center">
                                    <x-button icon="arrow-down-tray" title="Download file" wire:click="downloadFile({{ $note->id }})" blue
                                        flat />
                                    <x-button icon="trash" title="Elimina file" wire:click="deleteFile({{ $note->id }})" blue
                                        flat />
                                    <span class="text-xs text-gray-700 font-semibold "
                                        style="overflow-wrap: break-word; word-break: break-word;">{{ basename($note->url_file) }}</span>
                                </div>
                            @endif
                            <div x-data="{ openConfirm: false }">
                                <div class="border-t my-3 text-end">
                                    <x-button wire:click="toggleEditNote({{ $note->id }})" blue flat icon="pencil"
                                        class="font-bold mt-3" />
                                    <x-button @click="openConfirm =!openConfirm" red flat icon="trash"
                                        class="font-bold mt-3" />
                                </div>
                                <div x-show="openConfirm" class="border rounded-lg p-3 flex flex-col items-center">
                                    <p class="text-sm font-medium">Sei sicuro di eliminare la nota?</p>
                                    <x-button @click="openConfirm = false"
                                        wire:click="deleteNote({{ $item->id }}, {{ $note->id }})" red flat
                                        label="Elimina" class="font-bold mt-3" />
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Nessuna nota</h3>
                    <p class="mt-1 text-sm text-gray-500">Non ci sono note per questo progetto.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Overlay per chiudere la sidebar -->
    <div x-data="{ open: @entangle($attributes->wire('model')) }" x-show="open" x-cloak
        x-transition:enter="transition-opacity ease-linear duration-200" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-40 bg-black/30 bg-opacity-50" wire:click="{{ $onClose }}">
    </div>
