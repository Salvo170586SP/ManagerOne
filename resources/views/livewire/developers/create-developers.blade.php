<div class="-mt-2">
    <h2 class="text-xl font-bold mb-5">Aggiungi Developer</h2>
    <div class="bg-white rounded h-[calc(100vh-13rem)] overflow-y-auto p-6">

        <div class="flex justify-end items-center">
            <x-button icon="arrow-left" black label="Torna ai Developers" class="font-bold w-[200px] h-[32px]"
                wire:navigate href="/developers" />
        </div>

        <div class="px-5 w-full pb-[18px] mb-5 flex items-center justify-center ">
            <div class="text-gray-500 text-base flex items-center justify-center font-medium">
                <span
                    class="flex items-center justify-center h-[25px] w-[40px] text-gray-500 border border-gray-300 bg-gray-200 me-1 rounded font-medium">1</span>
                Generalità
            </div>
            <span
                class="inline-block @if ($currentStep >= 2) bg-gray-300 @else bg-gray-200 @endif w-[90px] h-[1px] mx-3"></span>
            <div
                class="@if ($currentStep >= 2) text-gray-500 @else text-[#B9B9B9] @endif flex items-center justify-center font-medium">
                <span
                    class="flex items-center font-medium justify-center h-[25px] w-[40px] @if ($currentStep >= 2) border border-gray-300 text-gray-500 bg-gray-200 @else  bg-gray-50 @endif me-1 rounded">2</span>
                Skills
            </div>
        </div>


        <div class="border-t my-4">
            @if($currentStep == 1)
            <div wire:key="img-{{ $currentStep }}-{{ now() }}" x-data="{ imageUrl: '' }"
                @form-reset.window="imageUrl = ''" class="flex flex-col justify-center items-center mb-10 mt-5">
                <div class="text-sm text-gray-600">
                    <div class="space-y-2">
                        <figure class="w-[150px] h-[150px] overflow-hidden border border-2 rounded-full">
                            <img :src="imageUrl ? imageUrl : 'https://static.thenounproject.com/png/261694-200.png'"
                                class="w-full h-full object-cover object-top bg-gray-100 dark:bg-[#4b4b4b] opacity-50"
                                :class="imageUrl ? 'opacity-100' : ''" alt="Anteprima immagine">
                        </figure>
                    </div>
                </div>
                <div class="flex flex-col items-center mt-5">
                    <label for="image_upload" class="mb-2">Carica Immagine</label>
                    <div class="relative group">
                        <input type="file" id="image_upload" name="image_upload"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*"
                            wire:model="img_url" x-on:change="imageUrl = URL.createObjectURL($event.target.files[0])">
                        <div
                            class="w-full h-[37px] rounded-md bg-gray-400 group-hover:bg-gray-600 dark:bg-[#505050] dark:group-hover:bg-[#585858] text-white flex items-center justify-center px-5 shadow">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                    clip-rule="evenodd" />
                            </svg>
                            Seleziona File
                        </div>
                        @error('img_url')
                        <small class="text-red-500">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="flex gap-2 mt-10">
                <x-input label="Nome" id="name" shadow wire:model="developerStep1.name" />
                <x-input label="Cognome" id="surname" shadow wire:model="developerStep1.surname" />
            </div>
            <div class="flex gap-2 mt-10">
                <x-input label="Numero di Telefono" id="phone" shadow wire:model="developerStep1.phone" />
                <x-input label="Città" id="city" shadow wire:model="developerStep1.city" />
                <x-input type="email" id="email" label="Email" shadow wire:model="developerStep1.email" />
            </div>

            <div class="flex justify-end mt-5">
                <x-button type="button" wire:click="addStep" black label="Avanti"
                    class="font-bold w-[200px] h-[32px]" />
            </div>
            @else
            <div class="flex gap-2 mt-10">
                <x-select label="Cerca un Tipo" id="type" shadow placeholder="Seleziona un Tipo" wire:key="type-{{ $currentStep }}-{{ now() }}"
                    wire:model.live="developerStep2.type" :options="$types" option-label="name" option-value="id" />
                <x-select label="Cerca una categoria" id="category" wire:key="category-{{ $currentStep }}-{{ now() }}"
                    shadow wire:model.live="developerStep2.category" placeholder="Seleziona una categoria"
                    :options="$categories" option-label="name" option-value="id" />
                <x-select label="Cerca una sede" id="workplace" wire:key="workplace-{{ $currentStep }}-{{ now() }}"
                    shadow wire:model.live="developerStep2.workplace" placeholder="Seleziona una sede"
                    :options="$workplaces" option-label="name" option-value="id" />
                <x-select label="Cerca una posizione" id="level" wire:key="level-{{ $currentStep }}-{{ now() }}" shadow
                    wire:model.live="developerStep2.level" placeholder="Seleziona una posizione" :options="$levels"
                    option-label="name" option-value="id" />
            </div>
            <div class="flex justify-end gap-2 mt-5">
                <x-button type="button" wire:click="backStep" gray label="Indietro"
                    class="font-bold w-[200px] h-[32px]" />
                <x-button type="button" wire:click="createDeveloper" black label="Aggiungi"
                    class="font-bold w-[200px] h-[32px]" />
            </div>
            @endif
        </div>
    </div>
</div>