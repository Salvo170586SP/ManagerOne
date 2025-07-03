<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-gray-100">
    <flux:sidebar sticky stashable class="bg-white">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <div class="ms-4 flex items-center font-bold text-xl">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 me-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="m6.115 5.19.319 1.913A6 6 0 0 0 8.11 10.36L9.75 12l-.387.775c-.217.433-.132.956.21 1.298l1.348 1.348c.21.21.329.497.329.795v1.089c0 .426.24.815.622 1.006l.153.076c.433.217.956.132 1.298-.21l.723-.723a8.7 8.7 0 0 0 2.288-4.042 1.087 1.087 0 0 0-.358-1.099l-1.33-1.108c-.251-.21-.582-.299-.905-.245l-1.17.195a1.125 1.125 0 0 1-.98-.314l-.295-.295a1.125 1.125 0 0 1 0-1.591l.13-.132a1.125 1.125 0 0 1 1.3-.21l.603.302a.809.809 0 0 0 1.086-1.086L14.25 7.5l1.256-.837a4.5 4.5 0 0 0 1.528-1.732l.146-.292M6.115 5.19A9 9 0 1 0 17.18 4.64M6.115 5.19A8.965 8.965 0 0 1 12 3c1.929 0 3.716.607 5.18 1.64" />
              </svg>
              
             ManagerOne
        </div>

        <flux:navlist variant="outline">
            <flux:navlist.group class="grid mt-5">
                @role('super_admin')
                 <flux:navlist.item icon="users" :href="route('clients.index')"
                    :current="request()->routeIs('clients.index')" wire:navigate>Anagrafica Clienti</flux:navlist.item>
                    <hr class="my-3">
                    @endrole
                 <flux:navlist.item icon="presentation-chart-line" :href="route('projects.index')"
                    :current="request()->routeIs('projects.index')" wire:navigate>Progetti
                </flux:navlist.item>
                <flux:navlist.item icon="shield-check" :href="route('approved-projects.index')"
                    :current="request()->routeIs('approved-projects.index')" wire:navigate>Progetti Approvati
                </flux:navlist.item>
                @role('super_admin')
                <flux:navlist.item icon="lock-closed" :href="route('delivered-projects.index')"
                    :current="request()->routeIs('delivered-projects.index')" wire:navigate>Progetti Consegnati
                </flux:navlist.item>
                @endrole
                <hr class="my-3">
                <flux:navlist.item icon="puzzle-piece" :href="route('tasks.index-tasks')"
                :current="request()->routeIs('tasks.index-tasks')" wire:navigate>Gestione Tasks
                </flux:navlist.item>
                @role('super_admin')
                <flux:navlist.item icon="document-currency-euro" :href="route('invoices.index')"
                :current="request()->routeIs('invoices.index')" wire:navigate>Fatture
                </flux:navlist.item>
                @endrole
                <flux:navlist.item icon="document-duplicate" :href="route('documents.index')"
                :current="request()->routeIs('documents.index')" wire:navigate>Documenti
                </flux:navlist.item>
                
                <flux:navlist.item icon="calendar" :href="route('calendar.index')"
                :current="request()->routeIs('calendar.index')" wire:navigate>Calendario
                </flux:navlist.item>
                <hr class="my-3">
                @role('super_admin')
                <flux:navlist.item icon="identification" :href="route('developers.index')"
                :current="request()->routeIs('developers.index')" wire:navigate>Developers
                </flux:navlist.item>
                @endrole
                <flux:navlist.item icon="user-group" :href="route('teams.index')"
                :current="request()->routeIs('teams.index')" wire:navigate>Gestione Teams
                </flux:navlist.item>
                @role('super_admin')
                <flux:navlist.item icon="exclamation-triangle" :href="route('logs.index')"
                :current="request()->routeIs('logs.index')" wire:navigate>Logs
                </flux:navlist.item>
                @endrole
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
    @stack('scripts')
    @livewireScripts
</body>

</html>