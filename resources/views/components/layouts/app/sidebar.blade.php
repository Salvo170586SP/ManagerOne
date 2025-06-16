<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-gray-100">
    <flux:sidebar sticky stashable class="bg-white">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <div class="ms-4 flex items-center font-bold text-xl">
             ManagerOne
        </div>

        <flux:navlist variant="outline">
            <flux:navlist.group class="grid mt-5">
                <flux:navlist.item icon="users" :href="route('clients.index')"
                    :current="request()->routeIs('clients.index')" wire:navigate>Anagrafica Clienti</flux:navlist.item>
                    <hr class="my-3">
                <flux:navlist.item icon="presentation-chart-line" :href="route('projects.index')"
                    :current="request()->routeIs('projects.index')" wire:navigate>Progetti
                </flux:navlist.item>
                <flux:navlist.item icon="presentation-chart-line" :href="route('approved-projects.index')"
                    :current="request()->routeIs('approved-projects.index')" wire:navigate>Progetti Approvati
                </flux:navlist.item>
                <flux:navlist.item icon="presentation-chart-line" :href="route('delivered-projects.index')"
                    :current="request()->routeIs('delivered-projects.index')" wire:navigate>Progetti Consegnati
                </flux:navlist.item>
                <hr class="my-3">
                <flux:navlist.item icon="puzzle-piece" :href="route('tasks.task-list')"
                :current="request()->routeIs('tasks.task-list')" wire:navigate>Gestione Tasks
                </flux:navlist.item>
                <flux:navlist.item icon="document-currency-euro" :href="route('invoices.index')"
                :current="request()->routeIs('invoices.index')" wire:navigate>Fatture
                </flux:navlist.item>
                <hr class="my-3">
                <flux:navlist.item icon="identification" :href="route('developers.index')"
                :current="request()->routeIs('developers.index')" wire:navigate>Developers
                </flux:navlist.item>
                <flux:navlist.item icon="user-group" :href="route('teams.index')"
                :current="request()->routeIs('teams.index')" wire:navigate>Gestione Teams
                </flux:navlist.item>
                <hr class="my-3">
                <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')"
                    wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
            </flux:navlist.group>
        </flux:navlist>

        <flux:spacer />
    </flux:sidebar>

    <!-- Mobile User Menu -->
    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <flux:spacer />

        <flux:dropdown position="top" align="end">
            <flux:profile :initials="auth()->user()->initials()" icon-trailing="chevron-down" />

            <flux:menu>
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>

                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:header>
    
    <livewire:headernav />
    {{ $slot }}

    @fluxScripts
</body>

</html>