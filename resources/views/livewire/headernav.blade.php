<div class="mx-8 mt-4 hidden lg:block relative">
    <div class="bg-white rounded w-full h-[80px] p-3 flex item-center justify-end" x-data="{ isOpen: false, imgUrl: '{{ auth()->user()->img_url ? asset('storage/' . auth()->user()->img_url) : 'https://static.thenounproject.com/png/261694-200.png' }}' }"
        @window.profile-updated.window="if($event.detail.imgUrl) imgUrl = $event.detail.imgUrl"
        @click.away="isOpen = false">

        {{-- notifiche --}}
        <div class="me-5 relative flex items-center" x-data="{ isOpen: false }" @click.away="isOpen = false">
            <x-button wire:click="markAsRead" @click="isOpen = !isOpen" icon="bell" lg black flat>
                @if ($unreadCount > 0)
                    <span
                        class="absolute top-3 right-4 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">{{ $unreadCount }}</span>
                @endif
            </x-button>
            <div x-show="isOpen" x-cloak
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="p-3 bg-white w-[300px] rounded-lg z-50 shadow-lg absolute top-18 right-0">
                @if ($notifications->isNotEmpty())
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <span
                                class="inline-block w-6 h-6 rounded-full bg-gray-400 text-center text-white">{{ $notifications->count() }}</span>
                            <x-button wire:click="destroyAll" red flat label="Elimina tutte" icon="trash"
                                class="text-sm" />
                        </div>
                        @foreach ($notifications as $notification)
                            <div class="border-b last:border-b-0 py-2 flex justify-between items-start">
                                <div>
                                    <p class="font-bold">{{ $notification->data['title'] }}</p>
                                    <p class="text-sm">{{ $notification->data['message'] }}</p>
                                </div>
                                <x-button wire:click="destroy('{{ $notification->id }}')" icon="trash" red flat
                                    class="ml-2 text-red-500 hover:text-red-700 text-xs" />
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex flex-col items-center text-gray-500 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9.143 17.082a24.248 24.248 0 0 0 3.844.148m-3.844-.148a23.856 23.856 0 0 1-5.455-1.31 8.964 8.964 0 0 0 2.3-5.542m3.155 6.852a3 3 0 0 0 5.667 1.97m1.965-2.277L21 21m-4.225-4.225a23.81 23.81 0 0 0 3.536-1.003A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6.53 6.53m10.245 10.245L6.53 6.53M3 3l3.53 3.53" />
                        </svg>
                        nessuna notifica
                    </div>
                @endif
            </div>
        </div>

        {{-- account --}}
        <div class="flex items-center">
            <x-dropdown position="bottom">
                <x-slot name="trigger">
                    <x-button flat slate>
                        <figure class="w-[40px] h-[40px]">
                            <img class="w-full h-full rounded-full border bg-white  dark:border-[#505050] dark:bg-[#505050] object-cover object-top"
                                :src="imgUrl" alt="{{ auth()->user()->fullName() }}">
                        </figure>
                        <div class="flex flex-col ms-2">
                            <div class="font-bold text-xs uppercase flex flex-col items-start">
                                <div>

                                    {{ Str::limit(auth()->user()->name, 17) }}
                                </div>
                                <div>
                                    {{ Str::limit(auth()->user()->surname, 17) }}
                                </div>
                            </div>
                            <span class="text-sm text-start">
                                {{ auth()->user()->roles->first()->name }}
                            </span>
                        </div>
                    </x-button>
                </x-slot>

                <div>
                    <flux:menu.item :href="route('settings.profile')"
                        class="cursor-pointer hover:bg-gray-100 text-start" icon="cog" wire:navigate>
                        {{ __('Impostazioni') }}
                    </flux:menu.item>
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                            class="cursor-pointer hover:bg-gray-100 text-start">
                            {{ __('Esci') }}
                        </flux:menu.item>
                    </form>
                </div>
            </x-dropdown>
        </div>
    </div>
</div>
