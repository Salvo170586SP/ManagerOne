<div class="-mt-2" wire:key="{{ $componentId }}">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-bold mb-5">Calendario</h2>
        @if (session('message'))
            <div class="bg-gray-200 border dark:bg-[#474747] dark:border-0 mx-8 rounded relative mb-4">
                <span class="block p-5">{{ session('message') }}</span>
            </div>
        @endif
    </div>

    <div class="bg-white rounded overflow-y-auto p-6" wire:ignore>
        <div class="mb-5">
            <div class="flex gap-3 items-center">
                <input id="searchInput" type="text" placeholder="Cerca..." class="w-64 border border-gray-300 rounded p-2" />
                <select id="eventFilter" class="w-[200px] border p-2 border-gray-300 rounded">
                    <option value="all">Tutti</option>
                    <option value="events">Solo Eventi</option>
                    <option value="tasks">Solo Tasks</option>
                </select>
            </div>
        </div>
        <small class="font-bold">
            @role('super_admin')
                (*) Clicca su una cella per creare un evento
            @endrole
        </small>
        <div id="{{ $componentId }}"></div>
    </div>

    @role('super_admin')
    <x-modal wire:model="showCreateModal" title="Crea Evento"  blur="sm" align="center">
        <x-form wire:submit.prevent="saveEvent" class="bg-white p-5 shadow-lg rounded-lg font-medium min-w-[1100px]">
            <h3 class="text-lg text-black">Crea Evento</h3>
            <x-input shadow label="Titolo" wire:model="title" />
            <x-textarea shadow label="Descrizione" wire:model="description" />
            <x-select shadow label="Partecipanti" :options="$this->potentialParticipants" option-value="id" option-label="name"
                wire:model="selectedParticipants" multiselect   />
            
       
            <x-checkbox shadow label="Importante" wire:model="is_available" />

            <x-slot:actions>
                <x-button label="Annulla" red @click="$wire.showCreateModal = false" />
                <x-button label="Salva" black type="submit" />
            </x-slot:actions>
        </x-form>
    </x-modal>
    @endrole
</div>

@assets
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.min.js"></script>
@endassets

@script
    <script>
        const calendarEl = document.getElementById('{{ $componentId }}');
        let allEvents = [
            ...@js($events),
            ...@js(array_map(function($task) {
                return [
                    'id' => 'task-' . $task['id'],
                    'title' => $task['title'],
                    'description' => $task['description'] ?? '',
                    'start' => $task['created_at'],
                    'end' => $task['due_date'],
                    'completed_at' => $task['completed_at'] ?? null,
                    'creator' => isset($task['developer_id']) && $task['developer_id'] ? (\App\Models\User::find($task['developer_id'])->name ?? 'N/D') : 'N/D',
                    'type' => 'task',
                    'color' => '#22c55e', // verde
                ];
            }, $tasks))
        ];

        function filterEvents(filterType, searchTerm) {
            let filtered = allEvents;
            if (filterType === 'events') {
                filtered = filtered.filter(event => !event.type || event.type === 'event');
            } else if (filterType === 'tasks') {
                filtered = filtered.filter(event => event.type === 'task');
            }
            if (searchTerm && searchTerm.trim() !== '') {
                const term = searchTerm.trim().toLowerCase();
                filtered = filtered.filter(event =>
                    (event.title && event.title.toLowerCase().includes(term)) ||
                    (event.description && event.description.toLowerCase().includes(term))
                );
            }
            return filtered;
        }

        const calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'it',
            buttonText: {
                today: 'Oggi'
            },
            firstDay: 1,
            initialView: 'dayGridMonth',
            events: allEvents,
            editable: true,
            selectable: true,
            select: (info) => {
                $wire.dispatch('calendar-select', [info]);
                calendar.unselect();
            },
            eventDrop: (info) => {
                Livewire.dispatch('update-event', {
                    eventId: info.event.id,
                    newStart: info.event.startStr,
                    newEnd: info.event.endStr
                });
            },
            dayCellDidMount: function(info) {
                // Se è Sabato (6) o Domenica (0)
                if (info.date.getDay() === 6 || info.date.getDay() === 0) {
                    info.el.classList.add('bg-gray-50');
                }
            },
            eventDidMount: (info) => {
                const start = new Date(info.event.start).toLocaleString('it-IT', {
                    dateStyle: 'short',
                    timeStyle: 'short'
                });
                const end = info.event.end ? new Date(info.event.end).toLocaleString('it-IT', {
                    dateStyle: 'short',
                    timeStyle: 'short'
                }) : 'N/D';
                const description = info.event.extendedProps.description || '';
                const participants = info.event.extendedProps.participants || [];
                const creator = info.event.extendedProps.creator || 'N/D';
                const isOwner = info.event.extendedProps.user_id === {{ auth()->id() }};
                const important = info.event.extendedProps.is_available ? 'Importante' : '';
                const type = info.event.extendedProps.type || 'event';
                const completed_at = info.event.extendedProps.completed_at ? new Date(info.event.extendedProps.completed_at).toLocaleString('it-IT', {
                    dateStyle: 'short',
                    timeStyle: 'short'
                }) : 'Non completata';

                let editButton = '';
                let deleteButton = '';
                let popoverContent = '';

                if (type === 'event') {
                    if (isOwner) {
                        editButton =
                            `<button onclick="Livewire.dispatch('edit-event', ['${info.event.id}'])" class="bg-blue-500 cursor-pointer hover:bg-blue-700 text-white font-bold py-1 px-2 rounded text-xs mr-2">Modifica</button>`;
                        deleteButton =
                            `<button onclick="if(confirm('Sei sicuro di voler eliminare questo evento?')) { Livewire.dispatch('delete-event', ['${info.event.id}']) }" class="bg-red-500 cursor-pointer hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-xs">Elimina</button>`;
                    }
                    popoverContent = `
                        <div class="p-2 font-medium">
                            <p class="text-xs px-2 rounded text-center bg-red-500 text-white mb-2"> ${important} </p>
                            <p><strong>${info.event.title}</strong></p>
                            <p class="text-xs mt-1">${description}</p>
                            <hr class="my-2">
                            <p class="text-xs"><strong>Creato da:</strong> ${creator}</p>
                            <p class="text-xs mt-1"><strong>Partecipanti:</strong> ${participants.join(', ') || 'Nessuno'}</p>
                            <hr class="my-2">
                            <p class="text-xs"><strong>Inizio:</strong> ${start}</p>
                            <p class="text-xs"><strong>Fine:</strong> ${end}</p>
                            <div class="text-center mt-2">
                                ${editButton}
                                ${deleteButton}
                            </div>
                        </div>
                    `;
                } else if (type === 'task') {
                    popoverContent = `
                        <div class="p-2 font-medium">
                            <p class="text-xs px-2 rounded text-center bg-green-500 text-white mb-2">Task</p>
                            <p><strong>${info.event.title}</strong></p>
                            <p class="text-xs mt-1">${description}</p>
                            <hr class="my-2">
                            <p class="text-xs"><strong>Assegnata a:</strong> ${creator}</p>
                            <p class="text-xs"><strong>Creazione:</strong> ${start}</p>
                            <p class="text-xs"><strong>Scadenza:</strong> ${end}</p>
                            <p class="text-xs"><strong>Completata il:</strong> ${completed_at}</p>
                        </div>
                    `;
                }

                // Inizializza tippy solo se è definito
                if (typeof tippy !== 'undefined') {
                    tippy(info.el, {
                        content: popoverContent,
                        allowHTML: true,
                        interactive: true,
                        trigger: 'mouseenter',
                        hideOnClick: true,
                        appendTo: () => document.body,
                    });
                }
            }
        });

        calendar.render();

        // Inizializza tippy dopo ogni update Livewire
        if (window.Livewire) {
            window.Livewire.hook('message.processed', (message, component) => {
                if (typeof tippy !== 'undefined') {
                    document.querySelectorAll('[data-tippy-content]').forEach(el => {
                        if (!el._tippy) {
                            tippy(el);
                        }
                    });
                }
            });
        }

        function updateCalendarEvents() {
            const filterType = document.getElementById('eventFilter').value;
            const searchTerm = document.getElementById('searchInput').value;
            const filteredEvents = filterEvents(filterType, searchTerm);
            calendar.removeAllEvents();
            calendar.addEventSource(filteredEvents);
        }

        document.getElementById('eventFilter').addEventListener('change', updateCalendarEvents);
        document.getElementById('searchInput').addEventListener('input', updateCalendarEvents);

        $wire.on('event-created', ({ eventData }) => {
            allEvents.push(eventData);
            updateCalendarEvents();
        });

        $wire.on('event-deleted', (eventId) => {
            allEvents = allEvents.filter(event => event.id !== eventId);
            const event = calendar.getEventById(eventId);
            if (event) {
                event.remove();
            } else {
                updateCalendarEvents();
            }
        });

        $wire.on('event-updated', ({ eventData }) => {
            const index = allEvents.findIndex(event => event.id === eventData.id);
            if (index !== -1) {
                allEvents[index] = eventData;
            }
            updateCalendarEvents();
        });
    </script>
@endscript