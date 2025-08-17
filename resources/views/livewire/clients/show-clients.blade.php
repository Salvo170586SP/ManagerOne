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
            <div class="w-full flex justify-end mb-5 pb-5 border-b">
                <x-button icon="arrow-left" black label="Torna ai Clienti" class="font-bold w-[200px] h-[32px]"
                    wire:navigate href="/clients" />
            </div>
            
            <livewire:clients.components.table-projects-show :client="$client" />
            <livewire:clients.components.table-invoices-show :client="$client" />
        </div>
    </div>
</div>