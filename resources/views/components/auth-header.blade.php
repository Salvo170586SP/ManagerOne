@props([
    'title',
    'description',
])

<div class="flex w-full flex-col">
    <flux:heading size="lg" class="text-black">{{ $title }}</flux:heading>
    <flux:subheading class="text-black">{{ $description }}</flux:subheading>
</div>
