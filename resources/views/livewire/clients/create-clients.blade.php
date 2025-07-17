<div class="-mt-2">
    <h2 class="text-xl font-bold mb-5">Aggiungi Cliente</h2>
    <div class="bg-white border border-gray-300 rounded-lg h-[calc(100vh-20rem)] overflow-y-auto p-6">

        <div class="flex justify-end items-center">
            <x-button icon="arrow-left" black label="Torna ai Clienti" class="font-bold w-[200px] h-[32px]" wire:navigate
                href="/clients" />
        </div>

        <form wire:submit.prevent="submit" class="border-t my-4">
            <div x-data="{ imageUrl: '' }" @form-reset.window="imageUrl = ''"
                class="flex flex-col justify-center items-center mb-10 mt-5">
                <div class="text-sm text-gray-600">
                    <div class="space-y-2">
                        <figure
                            class="w-[130px] h-[130px] overflow-hidden border border-gray-300 rounded-full flex items-center justify-center bg-gray-50">
                            <img x-show="imageUrl" :src="imageUrl"
                                class="w-full h-full object-cover object-top rounded-full" alt="Anteprima immagine">
                            <svg x-show="!imageUrl" xmlns="http://www.w3.org/2000/svg" fill="none"
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
                <x-input label="Nome" shadow wire:model="name" />
                <x-input label="Cognome" shadow wire:model="surname" />
            </div>
            <div class="flex gap-2 mt-10">
                <x-input label="Numero di Telefono" shadow wire:model="phone" />
                <x-input label="Città" shadow wire:model="city" />
                <x-input type="email" label="Email" shadow wire:model="email" />
            </div>

            <div class="flex justify-end mt-5">
                <x-button type="submit" black label="Aggiungi" class="font-bold w-[200px] h-[32px]" />
            </div>
        </form>
    </div>
</div>
