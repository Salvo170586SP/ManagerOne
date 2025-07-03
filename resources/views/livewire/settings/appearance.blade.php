<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<section class="w-full">
    @include('partials.settings-heading')
    <div class="bg-white border border-gray-300 rounded-lg p-5">
        <x-settings.layout :heading="__('Stile')">
            <flux:radio.group x-data variant="segmented" x-model="$flux.appearance">
                <flux:radio value="light" icon="sun">{{ __('Light') }}</flux:radio>
                <flux:radio value="dark" icon="moon">{{ __('Dark') }}</flux:radio>
                <flux:radio value="system" icon="computer-desktop">{{ __('Sistema') }}</flux:radio>
            </flux:radio.group>
        </x-settings.layout>
    </div>
</section>
