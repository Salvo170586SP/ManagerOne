<div class="-mt-2">
    <h2 class="text-xl font-bold mb-5">Dettagli Cliente</h2>
    <div class="flex mx-auto text-black">
        <div class="w-[350px] h-auto bg-white p-5 me-5 border border-gray-300 rounded-lg">
            <div class="flex items-center justify-center">
                @isset($client->img_url)
                <figure class="w-[100px] h-[100px]">
                    <img class="w-full h-full rounded-full border border-gray-300 object-cover object-top"
                        src="{{ asset('/storage/' . $client->img_url) }}" alt="{{ $client->fullName() }}">
                </figure>
                @else
                <div
                    class="w-[100px] h-[100px] border border-gray-300 rounded-full bg-white overflow-hidden flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-7">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                </div>
                @endisset
            </div>
            <div class="font-bold text-sm text-center uppercase my-5 pb-5 border-b">
                {{ $client->fullName() }}
            </div>
            <div class="mb-5">
                <div class="font-medium text-sm">ID:</div>
                <div class="text-sm">
                    @if ($client->IdClient)
                    #CL-{{ $client->IdClient }}
                    @else
                    #CL
                    @endif
                </div>
            </div>
            <div class="mb-5">
                <div class="font-medium text-sm">Email:</div>
                <div class="text-sm">
                    {{ $client->email ?? '-' }}
                </div>
            </div>
            <div class="mb-5">
                <div class="font-medium text-sm">Telefono:</div>
                <div class="text-sm">
                    {{ $client->phone ?? '-' }}</div>
            </div>

            <div class="mb-5">
                <div class="font-medium text-sm">Città:</div>
                <div class="text-sm">
                    {{ $client->city ?? '-' }}
                </div>
            </div>
        </div>

        <div class="w-full p-6 bg-white border border-gray-300 rounded-lg">
            <div class="w-full flex justify-between mb-5 pb-5 border-b">
                <h3 class="text-xl font-semibold ">Progetti</h3>
                <x-button icon="arrow-left" black label="Torna ai Clienti" class="font-bold w-[200px] h-[32px]"
                    wire:navigate href="/clients" />
            </div>

            <div>
                <x-card shadow="false" class="w-[350px] border border-gray-300 rounded-lg my-5">
                    <div class="flex justify-between">
                        <div class="bg-slate-500 w-[50px] h-[50px] rounded-full flex justify-center items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="white" class="size-7">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5m.75-9 3-3 2.148 2.148A12.061 12.061 0 0 1 16.5 7.605" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-xl text-end font-bold">
                                {{ $client->projects->count() }}
                            </div>
                            <div class="text-sm">
                                Totale Progetti
                            </div>
                        </div>
                    </div>
                </x-card>


                <div class="{{-- overflow-x-auto --}}">
                    @if ($projectClient->count() > 0)
                    <table class="min-w-full divide-y border divide-gray-200">
                        <thead>
                            <tr>
                                <th scope="col"
                                    class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                    ID</th>
                                <th scope="col"
                                    class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                    Nome
                                </th>
                                <th scope="col"
                                    class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                    Preventivo
                                </th>
                                <th scope="col"
                                    class="px-6 py-5 text-center text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                    Stato
                                    Approvazione</th>
                                <th scope="col"
                                    class="px-6 py-5 text-center text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                    Stato
                                    Progettazione</th>
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
                            @foreach ($projectClient as $project)
                            <tr wire:key="clientproject-{{ $project->id }}-{{  str()->random(10) }}">
                                <td class="px-6 py-4 whitespace-nowrap">id</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $project->name }} </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $project->preventive }} €</td>
                                <td class="px-6 py-4 flex justify-center text-center whitespace-nowrap">
                                    @if ($project->is_available)
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
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($project->state)
                                    <div
                                        class="rounded ms-2 font-medium text-center {{ $this->getStateColor($project->state) }}">
                                        {{ $this->getStateName($project->state) }}
                                    </div>
                                    @else
                                    -
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $project->createDate() }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex justify-center">
                                        <x-button flat black icon="eye" wire:navigate
                                            href="/projects/{{ $project->id }}" />
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="py-3">
                        {{ $projectClient->links('vendor.pagination.tailwind') }}
                    </div>
                    @else
                    <div class="text-sm text-center font-medium italic text-gray-400 py-10">
                        Non ci sono progetti associati a questo cliente
                    </div>
                    @endif
                </div>
            </div>

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
                            <td class="px-6 py-4 whitespace-nowrap">
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
                                    <x-button gray flat icon="eye" label="Visualizza"
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
        </div>
    </div>
</div>