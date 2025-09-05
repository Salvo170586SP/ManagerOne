<div class="-mt-2">
    <h2 class="text-xl font-bold mb-5">Aggiungi Membro</h2>
    <div class="bg-white rounded-lg border border-gray-300 {{-- h-[calc(100vh-20rem)] --}} overflow-y-auto p-6">

        <div class="flex justify-end items-center">
            <x-button icon="arrow-left" black label="Torna ai Membri" class="font-bold w-[200px] h-[32px]" wire:navigate
                href="/developers" />
        </div>

        <div class="px-5 w-full pb-[18px] -mt-5 mb-5 flex items-center justify-center ">
            {{-- step1 --}}
            <div
                class="@if ($currentStep >= 1) text-gray-500 @else text-[#B9B9B9] @endif flex items-center justify-center font-medium">
                <span
                    class="flex items-center font-medium justify-center h-[25px] w-[40px] @if ($currentStep >= 1) border border-gray-300 text-gray-500 bg-gray-200 @else  bg-gray-50 @endif me-1 rounded">1</span>
                Scegli Tipo
            </div>

            {{-- step2 --}}
            <span
                class="inline-block @if ($currentStep >= 2) bg-gray-300 @else bg-gray-200 @endif w-[90px] h-[1px] mx-3"></span>
            <div
                class="@if ($currentStep >= 2) text-gray-500 @else text-[#B9B9B9] @endif flex items-center justify-center font-medium">
                <span
                    class="flex items-center font-medium justify-center h-[25px] w-[40px] @if ($currentStep >= 2) border border-gray-300 text-gray-500 bg-gray-200 @else  bg-gray-50 @endif me-1 rounded">2</span>
                Generalità
            </div>

            {{-- step3 --}}
            <span
                class="inline-block @if ($currentStep == 3) bg-gray-300 @else bg-gray-200 @endif w-[90px] h-[1px] mx-3"></span>
            <div
                class="@if ($currentStep == 3) text-gray-500 @else text-[#B9B9B9] @endif flex items-center justify-center font-medium">
                <span
                    class="flex items-center font-medium justify-center h-[25px] w-[40px] @if ($currentStep == 3) border border-gray-300 text-gray-500 bg-gray-200 @else  bg-gray-50 @endif me-1 rounded">3</span>
                Skills
            </div>
        </div>


        <div class="border-t">

            @if ($currentStep == 1)
            <div class="h-[400px] flex flex-col">
                <p class="text-gray-600 text-sm font-medium text-center mt-5 mb-10">
                    *Seleziona il tipo di membro che vuoi aggiungere e clicca su avanti
                </p>
                <div class="flex justify-center items-center gap-5">
                    <label class="relative cursor-pointer">
                        <input type="radio" name="type" value="developer" wire:model="developerStep1.type"
                            class="peer absolute opacity-0">
                        <div
                            class="w-[400px] h-[250px] text-gray-500 bg-gray-100  peer-checked:bg-gray-200 rounded-lg flex flex-col justify-center items-center border border-gray-400 gap-4 peer-checked:border-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-16 h-16">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-4.5 16.5" />
                            </svg>
                            <span class="text-lg font-medium">Developer</span>
                        </div>
                    </label>
                    <label class="relative cursor-pointer">
                        <input type="radio" name="type" value="project_manager" wire:model="developerStep1.type"
                            class="peer absolute opacity-0">
                        <div
                            class="w-[400px] h-[250px] text-gray-500 bg-gray-100  peer-checked:bg-gray-200 rounded-lg flex flex-col justify-center items-center border border-gray-400 gap-4 peer-checked:border-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-16 h-16">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-6.336l-3.276 3.277a3.004 3.004 0 0 1-2.25-2.25l3.276-3.276a4.5 4.5 0 0 0-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437 1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008Z" />
                            </svg>
                            <span class="text-lg font-medium">Project Manager</span>
                        </div>
                    </label>
                </div>

                <div class="mt-10 text-center">
                    @error('developerStep1.type')
                    <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="flex justify-end">
                <x-button type="button" wire:click="addStep" black label="Avanti"
                    class="font-bold w-[200px] h-[32px]" />
            </div>
            @elseif($currentStep == 2)
            <div wire:key="img-{{ $currentStep }}">
                <div x-data="{ 
                    imageUrl: @entangle('developerStep2.img_url').defer,
                    previewUrl: false 
                    }" class="flex flex-col justify-center items-center mb-10 mt-5">
                    <div class="text-sm text-gray-600">
                        <div class="space-y-2 relative">
                            <div x-show="previewUrl || imageUrl">
                                <div class="absolute top-0 right-0">
                                    <button type="button"
                                        class="font-bold w-[30px] h-[30px] bg-red-400 hover:bg-red-500 text-white flex justify-center items-center cursor-pointer rounded-full"
                                        wire:click="$set('developerStep2.img_url', null)" @click="imageUrl = null">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </div>
                                <figure class="w-[130px] h-[130px] overflow-hidden border border-gray-300 rounded-full">
                                    <img :src="previewUrl || imageUrl"
                                        class="w-full h-full object-cover object-top rounded-full"
                                        alt="Anteprima immagine">
                                </figure>
                            </div>

                            <div x-show="!previewUrl && !imageUrl" 
                                class="w-[130px] h-[130px] border border-gray-300 rounded-full bg-white overflow-hidden flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-10">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col items-center mt-5">
                        <label for="image_upload" class="mb-2">Carica Immagine</label>
                        <div class="relative group">
                            <input type="file" id="image_upload" name="image_upload"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*"
                                wire:model="developerStep2.img_url"
                                @change="imageUrl = URL.createObjectURL($event.target.files[0])">
                            <div
                                class="w-full h-[37px] rounded-md bg-gray-400 group-hover:bg-gray-600 text-white flex items-center justify-center px-5 shadow">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                        clip-rule="evenodd" />
                                </svg>
                                Seleziona File
                            </div>
                            @error('developerStep2.img_url')
                            <small class="text-red-500">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex gap-2 mt-10">
                <x-input label="Nome" id="name" shadow wire:model="developerStep2.name" />
                <x-input label="Cognome" id="surname" shadow wire:model="developerStep2.surname" />
            </div>
            <div class="flex gap-2 mt-10">
                <x-input label="Numero di Telefono" id="phone" shadow wire:model="developerStep2.phone" />
                <x-input label="Città" id="city" shadow wire:model="developerStep2.city" />
                <x-input type="email" id="email" label="Email" shadow wire:model="developerStep2.email" />
            </div>

            <div class="flex justify-end mt-5 gap-2">
                <x-button type="button" wire:click="backStep" gray label="Indietro"
                    class="font-bold w-[200px] h-[32px]" />
                <x-button type="button" wire:click="addStep" black label="Avanti"
                    class="font-bold w-[200px] h-[32px]" />
            </div>
            @else
            <div class="flex gap-2 mt-10">
                <x-select label="Seleziona una categoria" id="category"
                    wire:key="category-{{ $currentStep }}-{{ now() }}" shadow wire:model.live="developerStep3.category"
                    placeholder="Seleziona" :options="$categories" option-label="name" option-value="id" />
                <x-select label="Seleziona una sede" id="workplace" wire:key="workplace-{{ $currentStep }}-{{ now() }}"
                    shadow wire:model.live="developerStep3.workplace" placeholder="Seleziona" :options="$workplaces"
                    option-label="name" option-value="id" />
                <x-select label="Seleziona una posizione" id="level" wire:key="level-{{ $currentStep }}-{{ now() }}"
                    shadow wire:model.live="developerStep3.level" placeholder="Seleziona" :options="$levels"
                    option-label="name" option-value="id" />
            </div>
            <div class="flex justify-end items-end h-full  gap-2 mt-5">
                <x-button type="button" wire:click="backStep" gray label="Indietro"
                    class="font-bold w-[200px] h-[32px]" />
                <x-button type="button" wire:click="createDeveloper" black label="Aggiungi"
                    class="font-bold w-[200px] h-[32px]" />
            </div>
            @endif
        </div>
    </div>
</div>