<div class="mx-8 mt-4 hidden lg:block relative">
    <div class="bg-white rounded w-full h-[85px] p-3 flex item-center justify-end" x-data="{isOpen: false}"  @click.away="isOpen = false">
        <button @click="isOpen = !isOpen"
            class="flex items-center justify-end hover:bg-gray-50 focus:bg-gray-100 cursor-pointer transition rounded p-2">
            @isset(auth()->user()->img_url)
            <figure class="w-[50px] h-[50px]">
                <img class="w-full h-full rounded-full border bg-white  dark:border-[#505050] dark:bg-[#505050] object-cover object-top"
                    src="{{ auth()->user()->img_url  }}" alt="{{auth()->user()->fullName()}}">
            </figure>
            @else
            <div class="w-[50px] h-[50px] rounded-full border bg-white">
                <div class="w-full h-full text-4xl font-bold text-gray-200 ">
                    {{ auth()->user()->initials() }}
                </div>
            </div>
            @endisset
            <div class="flex flex-col ms-2">
                <span class="font-bold uppercase">
                    {{auth()->user()->fullName()}}
                </span>
                <span class="text-sm">
                    {{auth()->user()->roles->first()->name}}
                </span>
            </div>
        </button>

        <div x-cloak x-show="isOpen"
            class="w-[175px] h-auto bg-white flex flex-col justify-start items-start gap-1 rounded p-1 z-50 shadow absolute top-23 right-0 ">
            <flux:menu.item :href="route('settings.profile')" class="w-full cursor-pointer hover:bg-gray-100 text-start"
                icon="cog" wire:navigate>{{ __('Impostazioni') }}
            </flux:menu.item>
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                    class="w-full cursor-pointer hover:bg-gray-100 text-start">
                    {{ __('Esci') }}
                </flux:menu.item>
            </form>
        </div>
    </div>
</div>