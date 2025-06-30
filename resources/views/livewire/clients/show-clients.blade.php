<div class="-mt-2">
    <h2 class="text-xl font-bold mb-5">Dettagli Cliente</h2>
    <div class="flex mx-auto text-black h-[calc(100vh-13rem)]">
        <div class="w-[350px] h-auto bg-white p-5 me-5 rounded">
            <div class="flex items-center justify-center">
                @isset($client->img_url)
                    <figure class="w-[100px] h-[100px]">
                        <img class="w-full h-full rounded-full border dark:border-[#505050] dark:bg-[#505050] object-cover object-top"
                            src="{{ asset('/storage/' . $client->img_url) }}" alt="{{ $client->fullName() }}">
                    </figure>
                @else
                    <div
                        class="w-[100px] h-[100px] border rounded-full bg-white overflow-hidden flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-7">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                    </div>
                @endisset
            </div>
            <div class="font-bold text-sm text-center uppercase my-5">
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

        <div class="w-full  p-6 bg-white rounded">
            <div class="w-full flex justify-between mb-5 pb-5">
                <h3 class="text-xl font-semibold ">Progetti</h3>
                <x-button icon="arrow-left" black label="Torna ai Clienti" class="font-bold w-[200px] h-[32px]"
                    wire:navigate href="/clients" />
            </div>
            <div>
                <div>
                    <x-card shadow="false" class="w-[350px] border my-5">
                        <div class="flex justify-between">
                            <div class="bg-slate-500 w-[50px] h-[50px] rounded-full flex justify-center items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="white" class="size-7">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5m.75-9 3-3 2.148 2.148A12.061 12.061 0 0 1 16.5 7.605" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-xl text-end font-bold">
                                    {{ $client->projects->count() }}
                                </div>
                                <div class="text-sm">
                                    Numero Progetti
                                </div>
                            </div>
                        </div>
                    </x-card>


                    <div class="{{-- overflow-x-auto --}}">
                        @if ($client->projects->count() > 0)
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
                                    @foreach ($client->projects as $project)
                                        <tr wire:key="clientproject-{{ $project->id }}">
                                            <td class="px-6 py-4 whitespace-nowrap">id</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $project->name }} </td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $project->preventive }} €</td>
                                            <td class="px-6 py-4 flex justify-center text-center whitespace-nowrap">
                                                @if ($project->is_available)
                                                    <div class="bg-green-600 rounded-full text-white">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="size-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                                                        </svg>
                                                    </div>
                                                @else
                                                    <div class="bg-red-600 rounded-full text-white">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="size-6">
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
                        @else
                            <div class="text-center font-medium">
                                Non ci sono progetti associati a questo cliente
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="mt-10">
                <h3 class="text-lg font-semibold mb-5">Fatture</h3>
                <div class="flex flex-wrap gap-6">
                    @forelse ($invoices as $invoice)
                        <x-card class="border w-[300px]">
                            <div class="flex items-center justify-between mb-2">
                                <div class="font-bold text-sm">
                                    {{ $invoice->name ?? 'Fattura #' . $invoice->IdInvoice }}</div>
                                @if ($invoice->pdf_path)
                                    <a href="{{ asset('storage/' . $invoice->pdf_path) }}" target="_blank"
                                        class="text-blue-600 underline text-sm">PDF</a>
                                @endif
                            </div>
                            <div class="text-sm mb-1">
                                <span class="font-semibold">Progetto:</span>
                                {{ $invoice->project ? $invoice->project->name : '-' }}
                            </div>
                            <div class="text-sm mb-1">
                                <span class="font-semibold">Data creazione:</span>
                                {{ $invoice->createDate() }}
                            </div>
                        </x-card>
                    @empty
                        <div class="col-span-3 text-center font-medium py-10">Non ci sono fatture per questo cliente
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
