<div class="-mt-2">
    <h2 class="text-xl font-bold mb-5">Dettagli Cliente</h2>
    <div class="flex mx-auto text-black h-[calc(100vh-13rem)]">
        <div class="w-[350px] h-auto bg-white p-5 me-5 rounded">
            <div class="flex items-center justify-center">
                <figure class="w-[200px] h-[200px]">
                    <img class="w-full h-full rounded-lg border dark:border-[#505050] dark:bg-[#505050] object-cover object-top"
                        src="{{ isset($client->img_url) ? asset('/storage/'.$client->img_url) : 'https://static.thenounproject.com/png/261694-200.png' }}"
                        alt="{{$client->fullName()}}">
                </figure>
            </div>
            <div class="font-bold text-sm text-center uppercase my-5">
                {{$client->fullName()}}
            </div>
            <div class="flex items-center justify-start mb-2">
                <div class="font-medium text-sm">Email:</div>
                <div class="text-sm ms-1">
                    {{$client->email ?? '-'}}
                </div>
            </div>
            <div class="flex items-center justify-start mb-2">
                <div class="font-medium text-sm">Telefono:</div>
                <div class="text-sm ms-1">
                    {{$client->phone ?? '-'}}</div>
            </div>

            <div class="flex  items-center justify-start mb-2">
                <div class="font-medium text-sm">Città:</div>
                <div class="text-sm ms-1">
                    {{$client->city ?? '-'}}
                </div>
            </div>
        </div>

        <div class="w-full  p-6 bg-white rounded">
            <div class="w-full flex justify-end mb-5 pb-5">
                <x-button icon="arrow-left" black label="Torna ai Clienti" class="font-bold w-[200px] h-[32px]"
                    wire:navigate href="/clients" />
            </div>
            <div>
                <div>
                    <x-card shadow="false" class="w-[350px] border my-5">
                        <div class="flex justify-between">
                            <div class="bg-slate-500 w-[50px] h-[50px] flex justify-center items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="white" class="size-7">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5m.75-9 3-3 2.148 2.148A12.061 12.061 0 0 1 16.5 7.605" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-xl text-end font-bold">
                                    {{$client->projects->count()}}
                                </div>
                                <div class="text-sm">
                                    Numero Progetti
                                </div>
                            </div>
                        </div>
                    </x-card>


                    <div class="{{-- overflow-x-auto --}}">
                        @if($client->projects->count() > 0)
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
                                        class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                        Data
                                        Creazione</th>
                                    <th scope="col"
                                        class="px-6 py-5 text-left text-xs font-medium border text-gray-500 uppercase tracking-wider">
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($client->projects as $project)
                                <tr wire:key="clientproject-{{$project->id}}">
                                    <td class="px-6 py-4 whitespace-nowrap">id</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{$project->name}} </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{$project->preventive}} €</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{$project->createDate()}}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div class="flex justify-center">
                                            <x-button flat black icon="eye" wire:navigate
                                                href="/projects/{{$project->id}}" />
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
        </div>
    </div>
</div>