<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<section class="w-full">
    @include('partials.settings-heading')
    <div class="bg-white border border-gray-300 rounded-lg p-5">
        <x-settings.layout :heading="__('Stile')">
            <div class="text-zinc-600">Solo modalità chiara disponibile.</div>
        </x-settings.layout>
    </div>
</section>
