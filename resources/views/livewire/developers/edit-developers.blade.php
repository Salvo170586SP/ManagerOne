<div class="-mt-2">
    <h2 class="text-xl font-bold mb-5">Modifica Developer</h2>
    <div class="bg-white rounded h-[calc(100vh-13rem)] overflow-y-auto p-6">

        <div class="flex justify-end items-center">
            <x-button icon="arrow-left" black label="Torna ai Developers" class="font-bold w-[200px] h-[32px]"
                wire:navigate href="/developers" />
        </div>

        <div class="border-t my-4">
            <div   x-data="{ imageUrl: '' }"
                @form-reset.window="imageUrl = ''" class="flex flex-col justify-center items-center mb-10 mt-5">
                <div class="text-sm text-gray-600">
                    <div class="space-y-2">
                        <figure class="w-[200px] h-[200px] overflow-hidden shadow-md rounded-lg">
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
            <div class="flex gap-2 mt-5">
                <x-input label="Nome" id="name" shadow wire:model="name" />
                <x-input label="Cognome" id="surname" shadow wire:model="surname" />
            </div>
            <div class="flex gap-2 mt-5">
                <x-input label="Numero di Telefono" id="phone" shadow wire:model="phone" />
                <x-input label="Città" id="city" shadow wire:model="city" />
             </div>

          
            <div class="flex gap-2 mt-5">
                <x-select label="Cerca una categoria" id="category"  
                    shadow wire:model.live="category" placeholder="Seleziona una categoria"
                    :options="$categories" option-label="name" option-value="name" />
                <x-select label="Cerca una sede" id="workplace"  
                    shadow wire:model.live="workplace" placeholder="Seleziona una sede"
                    :options="$workplaces" option-label="name" option-value="name" />
                <x-select label="Cerca una posizione" id="level"  shadow
                    wire:model.live="level" placeholder="Seleziona una posizione" :options="$levels"
                    option-label="name" option-value="name" />
            </div>
            <div class="flex justify-end gap-2 mt-5">
                <x-button type="button" wire:click="editDeveloper" black label="Aggiungi"
                    class="font-bold w-[200px] h-[32px]" />
            </div>
        </div>
    </div>
</div>