<div class="-mt-2 relative h-[calc(100vh-13rem)]">
    <div class="flex justify-between items-center mb-5">
        <h2 class="text-xl font-bold">Chat</h2>
    </div>

    <div class="bg-white border shadow rounded-lg h-full flex overflow-hidden">
        <!-- Sidebar con lista utenti -->
        <div class="w-1/3 border-r border-gray-200 flex flex-col">
            <!-- Header sidebar -->
            <div class="h-[70px] p-4 border-b border-gray-200">
                <x-input wire:model.live="search" placeholder="Cerca utenti..." icon="magnifying-glass" shadow="false" />
            </div>

            <!-- Lista utenti -->
            <div class="flex-1 overflow-y-auto">
                @forelse($this->filteredUsers as $user)
                    <div wire:click="selectUser({{ $user->id }})"
                        class="p-4 border-b border-gray-100 hover:bg-gray-50 cursor-pointer transition-colors {{ $selectedUser && $selectedUser->id === $user->id ? 'bg-blue-50 border-r-2 border-blue-500' : '' }}">
                        <div class="flex items-center space-x-3">
                            <div class="relative">
                                <figure class="w-12 h-12 border rounded-full bg-white">
                                    <img src="{{ $user->img_url ? asset('storage/' . $user->img_url) : 'https://static.thenounproject.com/png/261694-200.png' }}"
                                        alt="{{ $user->fullName() }}" class="object-cover">
                                </figure>
                                @if ($unreadCounts[$user->id] > 0)
                                    <span
                                        class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                        {{ $unreadCounts[$user->id] > 99 ? '99+' : $unreadCounts[$user->id] }}
                                    </span>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-medium text-gray-900 truncate">
                                        {{ $user->fullName() }}
                                    </p>
                                    @if ($unreadCounts[$user->id] > 0)
                                        <span class="text-xs text-red-500 font-medium">
                                            {{ $unreadCounts[$user->id] }}
                                            nuov{{ $unreadCounts[$user->id] > 1 ? 'i' : 'o' }}
                                        </span>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-500 truncate">
                                    {{ $user->roles->first()->name ?? 'Utente' }}
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <p class="mt-2">Nessun utente trovato</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Area chat -->
        <div class="flex-1 flex flex-col">
            @if ($selectedUser)
                <!-- Header chat -->
                <div class="h-[70px] p-2 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                    <div class="flex items-center space-x-3">
                        <figure class="w-12 h-12 border rounded-full bg-white">
                        <img src="{{ $selectedUser->img_url ? asset('storage/' . $selectedUser->img_url) : 'https://static.thenounproject.com/png/261694-200.png' }}"
                            alt="{{ $selectedUser->fullName() }}" class="object-cover">
                        </figure>
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">
                                {{ $selectedUser->fullName() }}
                            </h3>
                            <p class="text-sm text-gray-500">
                                {{ $selectedUser->roles->first()->name ?? 'Utente' }}
                            </p>
                        </div>
                    </div>

                    <x-dropdown>
                        <x-dropdown.item icon="trash" label="Svuota chat" wire:click="clearChat"
                            wire:confirm="Sei sicuro di voler svuotare la chat?" />
                    </x-dropdown>
                </div>

                <!-- Messaggi -->
                <div class="flex-1 overflow-y-auto p-4 space-y-4" id="messages-container">
                    @forelse($messages as $message)
                        <div class="flex {{ $message['sender_id'] === auth()->id() ? 'justify-end' : 'justify-start' }}"
                            wire:key="message-{{ $message['id'] }}">
                            <div class="max-w-xs lg:max-w-md">
                                <div class="flex flex-col items-end">
                                    <div
                                        class="bg-{{ $message['sender_id'] === auth()->id() ? 'blue' : 'gray' }}-500 text-white px-4 py-2 rounded-lg {{ $message['sender_id'] === auth()->id() ? 'rounded-br-md' : 'rounded-bl-md' }}">
                                        <p class="text-sm">{{ $message['content'] }}</p>
                                    </div>
                                    <small class="text-xs opacity-50 mt-1">
                                        {{ \Carbon\Carbon::parse($message['created_at'])->format('H:i') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-500 py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                            <p class="mt-2">Inizia una conversazione</p>
                        </div>
                    @endforelse
                </div>

                <!-- Input messaggio -->
                <div class="p-4 border-t border-gray-200">
                    <form wire:submit="sendMessage" class="flex space-x-2">
                        <x-input wire:model="messageContent" placeholder="Scrivi un messaggio..." class="flex-1"
                            shadow="false" />
                        <x-button type="submit" icon="paper-airplane" black class="px-6">
                            Invia
                        </x-button>
                    </form>
                </div>
            @else
                <!-- Stato iniziale -->
                <div class="flex-1 flex items-center justify-center">
                    <div class="text-center text-gray-500">
                        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Seleziona un utente</h3>
                        <p class="mt-2 text-sm text-gray-500">
                            Scegli un utente dalla lista per iniziare una conversazione
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
