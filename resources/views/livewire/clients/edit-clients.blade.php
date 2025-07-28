<div class="-mt-2">
    <h2 class="text-xl font-bold mb-5">Modifica Cliente</h2>
    <div class="bg-white border border-gray-300 rounded-lg h-[calc(100vh-22rem)] overflow-y-auto p-6">
        <div class="flex justify-end items-center">
            <x-button icon="arrow-left" black label="Torna ai Clienti" class="font-bold w-[200px] h-[32px]"
                wire:navigate href="/clients" />
        </div>
        <div class="flex justify-end items-center my-4 border-t"></div>

        <div>
            <div x-data="{ imageUrl: '', showImage: true }" 
                @form-reset.window="imageUrl = ''"
                @img-deleted.window="showImage = false"
                class="flex flex-col items-center justify-center mb-10 mt-5">
                <div class="text-sm text-gray-600">
                    <div class="space-y-2 relative">
                        <div class="absolute top-0 right-0" x-show="showImage && '{{ $img_url }}'">
                            <button type="button" title="Elimina Immagine"
                                class="font-bold w-[30px] h-[30px] bg-red-400 hover:bg-red-500 text-white flex justify-center items-center cursor-pointer rounded-full"
                                wire:click="deleteImg">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </button>
                        </div>
                        <figure
                            class="w-[130px] h-[130px] overflow-hidden border border-gray-300 rounded-full flex items-center justify-center bg-gray-50">
                            <img x-show="showImage && imageUrl" :src="imageUrl"
                                class="w-full h-full object-cover object-top rounded-full" alt="Anteprima immagine">
                            <img x-show="showImage && !imageUrl && '{{ $img_url }}'" src="{{ $img_url }}"
                                class="w-full h-full object-cover object-top rounded-full" alt="Anteprima immagine">
                            <svg x-show="(!showImage && !imageUrl) || (!imageUrl && !'{{ $img_url }}')" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-10 mx-auto">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                        </figure>
                    </div>
                </div>
                <div class="flex flex-col items-center mt-5">
                    <label for="image_upload" class="mb-2">Carica Immagine</label>
                    <div class="relative group">
                        <input type="file" id="image_upload" name="image_upload"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*"
                            wire:model="img_url" x-on:change="imageUrl = URL.createObjectURL($event.target.files[0]); showImage = true">
                        <div
                            class="w-full h-[37px] rounded-md bg-gray-400 group-hover:bg-gray-600 dark:bg-[#505050] dark:group-hover:bg-[#585858] text-white flex items-center justify-center px-5 shadow">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                    clip-rule="evenodd" />
                            </svg>
                            Seleziona file
                        </div>
                        @error('img_url')
                        <small class="text-red-500">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="flex gap-2 mt-10">
                <x-input label="Nome" shadow wire:model="name" />
                <x-input label="Cognome" shadow wire:model="surname" />
            </div>
            <div class="flex gap-2 mt-10">
                <x-input label="Numero di Telefono" shadow wire:model="phone" />
                <x-input label="Città" shadow wire:model="city" />
            </div>

            <div class="flex justify-end mt-5">
                <x-button type="button" wire:click="editClient" black label="Modifica" class="font-bold w-[200px] h-[32px]" />
            </div>
        </div>
    </div>
</div>