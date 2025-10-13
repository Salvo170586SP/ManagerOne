<div class="-mt-2">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-bold">Dashboard</h2>
    </div>

    <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-3 mt-5">
        @role('admin')
        <livewire:dashboard.chart-total-projects />
        <livewire:dashboard.chart-total-clients />
        <livewire:dashboard.chart-total-tasks />
        <livewire:dashboard.chart-invoices />
        @endrole


        @role('developer')
        <div class="w-100">
            <button wire:navigate href="/projects" class="bg-slate-300/50 text-sm font-medium hover:bg-slate-300/80 rounded-lg px-3 py-2 flex items-center justify-between w-[200px] cursor-pointer">
                Progetti Assegnati <span class="inline-flex items-center justify-center w-7 h-7  bg-black rounded-full text-white">0</span>
            </button>
        </div>
        @endrole

    </div>
</div>