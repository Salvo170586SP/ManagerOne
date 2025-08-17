<div class="mt-10">
    <h3 class="text-lg font-semibold mb-5">Fatture</h3>
    <x-card shadow="false" class="w-[350px] border border-gray-300 rounded-lg my-5">
        <div class="flex justify-between">
            <div class="bg-slate-500 w-[50px] h-[50px] rounded-full flex justify-center items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="white" class="size-7">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 11.625h4.5m-4.5 2.25h4.5m2.121 1.527c-1.171 1.464-3.07 1.464-4.242 0-1.172-1.465-1.172-3.84 0-5.304 1.171-1.464 3.07-1.464 4.242 0M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg>
            </div>
            <div>
                <div class="text-xl text-end font-bold">
                    {{ $invoicesClient->count() }}
                </div>
                <div class="text-sm">
                    Totale Fatture
                </div>
            </div>
        </div>
    </x-card>
    @if($invoicesClient->count() > 0)
    <table class="min-w-full divide-y border divide-gray-200">
        <thead>
            <tr>
                <th scope="col"
                    class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                    Fattura</th>
                <th scope="col"
                    class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                    Progetto
                </th>
                <th scope="col"
                    class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                    Preventivo
                </th>
                <th scope="col"
                    class="px-6 py-5 text-center text-xs font-medium border text-gray-500 uppercase tracking-wider">
                    Pagato
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
        <tbody class="bg-white divide-y divide-gray-200 text-sm">
            @foreach($invoicesClient as $invoice)
            <tr wire:key="invoice-{{ $invoice->id }}-{{  str()->random(10) }}">
                <td class="px-6 py-4 whitespace-nowrap">{{ $invoice->name }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $invoice->project->name ?? '-'}}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $invoice->preventive }} €</td>
                <td class="px-6 py-4 whitespace-nowrap font-medium">
                    <div class="flex justify-center items-center">
                        @if ($invoice->is_available)
                        <div class="bg-green-500 rounded-full text-white px-3">
                            Pagato
                        </div>
                        @else
                        <div class="bg-red-600 rounded-full text-white px-3">
                            Non pagato
                        </div>
                        @endif
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $invoice->createDate() }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    <div class="flex justify-center">
                        <x-button gray flat icon="arrow-down-tray" label="Scarica" download
                            href="{{ asset('storage/' . $invoice->pdf_path) }}" />
                        <x-button gray flat icon="eye"
                            href="{{ asset('storage/' . $invoice->pdf_path) }}" target="_blank" />
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="py-3">
        {{ $invoicesClient->links('vendor.pagination.tailwind') }}
    </div>
    @else
    <div class="mb-3">
        <div class="text-sm text-center font-medium italic text-gray-400">Nessuna fattura
            disponibile</div>
    </div>
    @endif
</div>