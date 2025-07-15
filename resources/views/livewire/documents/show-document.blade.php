<div class="-mt-2 relative" x-data="{ isOpen: true }">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-bold mb-5">Documenti di {{ $user->fullName() }}</h2>
    </div>

    <div class="bg-white rounded-lg border border-gray-300 h-[calc(100vh-13rem)] overflow-y-auto p-6">
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
                <x-button icon="arrow-left" label="Torna all'Archivio" black wire:navigate href="/documents"
                    class="font-bold w-[200px] h-[32px]" />
            </div>
        </div>

        <x-card shadow="false" class="w-[350px] border border-gray-300 my-5">
            <div class="flex justify-between">
                <div class="bg-slate-500 w-[50px] h-[50px] rounded-full flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="white" class="size-7">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                </div>
                <div>
                    <div class="text-xl text-end font-bold">
                        @if ($user->type === 'developer' || $user->type === 'project_manager')
                            {{ $notesWithAttachments->count() + $chatAttachments->count() }}
                        @else
                            {{ $invoices->count() }}
                        @endif
                    </div>
                    <div class="text-sm">
                        Numero Documenti
                    </div>
                </div>
            </div>
        </x-card>

        @if ($user->type === 'client')
            <h3 class="text-sm font-bold mb-4">Allegati delle Fatture</h3>
            <table class="min-w-full divide-y border divide-gray-200">
                <thead>
                    <tr>
                        <th scope="col"
                            class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                            Nome File</th>

                        <th scope="col"
                            class="px-6 py-5 text-center text-xs font-medium border text-gray-500 uppercase tracking-wider">
                            Data
                            Creazione</th>

                        <th scope="col"
                            class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 text-sm">
                    @forelse ($invoices as $invoice)
                        <tr wire::key="{{ $invoice->id }}-{{ str()->random(10) }}">
                            <td>
                                <div class="flex items-center gap-2 p-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                    </svg>
                                    <div class="text-sm">{{ $invoice->name }}</div>
                                </div>
                            </td>
                            <td>
                                <div class="text-center p-2">
                                    {{ $invoice->created_at ? $invoice->createDate('created_at') : '-' }}
                                </div>
                            </td>
                            <td>
                                <div class="flex justify-end p-2">
                                    <x-button gray flat icon="arrow-down-tray" label="Scarica"
                                        wire:click="downloadInvoicePdf({{ $invoice->id }})" />
                                    <x-button gray flat icon="eye" label="Visualizza"
                                        href="{{ asset('storage/' . $invoice->pdf_path) }}" target="_blank" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td>
                                <div class="text-sm italic p-2">
                                    Cartella vuota, non ci sono documenti
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-6">
                {{ $invoices->links() }}
            </div>
        @else
            <div class="mt-10">
                <h3 class="text-sm font-bold mb-4">Allegati delle Note</h3>
                <table class="min-w-full divide-y border divide-gray-200">
                    <thead>
                        <tr>
                            <th scope="col"
                                class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                Nome File</th>

                            <th scope="col"
                                class="px-6 py-5 text-center text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                Data
                            </th>

                            <th scope="col"
                                class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 text-sm">
                        @forelse ($notesWithAttachments as $note)
                            <tr wire::key="{{ $note->id }}-{{ str()->random(10) }}">
                                <td>
                                    <div class="flex items-center gap-2 p-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                        </svg>
                                        <div class="text-sm" title="{{ basename($note->url_file) }}">
                                            {{ Str::limit(basename($note->url_file), 15) }}</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-center p-2">
                                        {{ $note->created_at ? $note->getDate($note->created_at) : '-' }}
                                    </div>
                                </td>
                                <td>
                                    <div class="flex justify-end p-2">
                                        <x-button gray flat icon="arrow-down-tray" label="Scarica" download
                                            href="{{ asset('storage/' . $note->url_file) }}" />
                                        <x-button gray flat icon="eye" label="Visualizza"
                                            href="{{ asset('storage/' . $note->url_file) }}" target="_blank" />
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td>
                                    <div class="text-sm text-center font-medium italic text-gray-400 p-2">
                                        Cartella vuota, non ci sono documenti
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-6">
                    {{ $notesWithAttachments->links('vendor.pagination.tailwind') }}
                </div>
            </div>

            @if (in_array($user->type, ['developer', 'project_manager']))
                <div class="mt-10">
                    <h3 class="text-sm font-bold mb-4">Allegati della Chat</h3>

                    <table class="min-w-full divide-y border divide-gray-200">
                        <thead>
                            <tr>
                                <th scope="col"
                                    class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                    Nome File</th>
                                <th scope="col"
                                    class="px-6 py-5 text-center text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                    Ricevuto da</th>
                                <th scope="col"
                                    class="px-6 py-5 text-center text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                    Inviato a</th>

                                <th scope="col"
                                    class="px-6 py-5 text-center text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                    Data
                                </th>

                                <th scope="col"
                                    class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 text-sm">
                            @forelse ($chatAttachments as $attachment)
                                <tr wire::key="{{ $attachment->id }}-{{ str()->random(10) }}">
                                    <td>
                                        <div class="flex items-center gap-2 p-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                            </svg>
                                            <div class="text-sm"
                                                title="{{ basename($attachment->attachment_path) }}">
                                                {{ Str::limit(basename($attachment->attachment_path), 15) }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="p-2 text-center">
                                            {{ $attachment->sender->fullName() }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="p-2 text-center">
                                            {{ $attachment->receiver->fullName() }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center p-2">
                                            {{ $attachment->created_at ? $attachment->getDate($attachment->created_at) : '-' }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex justify-end p-2">
                                            <x-button gray flat icon="arrow-down-tray" label="Scarica"
                                                wire:click="downloadChatAttachment({{ $attachment->id }})" />
                                            <x-button gray flat icon="eye" label="Visualizza"
                                                href="{{ asset('storage/' . $attachment->attachment_path) }}"
                                                target="_blank" />
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td>
                                        <div class="text-sm text-center font-medium italic text-gray-400 p-2">
                                            Cartella vuota, non ci sono documenti
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-6">
                        {{ $chatAttachments->links('vendor.pagination.tailwind') }}
                    </div>
                </div>
            @endif
        @endif
    </div>
</div>
