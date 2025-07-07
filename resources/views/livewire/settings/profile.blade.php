<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new class extends Component {
    use WithFileUploads;
    public string $name = '';
    public string $surname = '';
    public string $email = '';
    public $img_url = null;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->surname = Auth::user()->surname;
        $this->email = Auth::user()->email;
        $this->img_url = Auth::user()->img_url;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();
 
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        ];

        if (is_object($this->img_url)) {
            $rules['img_url'] = ['nullable', 'image', 'max:2048'];
        }

        $validated = $this->validate($rules);

        if (is_object($this->img_url)) {
            // Se è un file appena caricato, salvalo e aggiorna il path
            $url = $this->img_url->store('imgsClient', 'public');
            $validated['img_url'] = $url;
        } else {
            // Se è una stringa (già salvata), mantieni il valore attuale
            $validated['img_url'] = $this->img_url;
        }

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->img_url = $user->img_url;

        $this->dispatch('profile-updated', [
            'imgUrl' => $user->img_url ? asset('storage/' . $user->img_url) : null,
        ]);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>


<section class="w-full">
    @include('partials.settings-heading')

    <div class="bg-white border border-gray-300 rounded-lg p-5">
        <x-settings.layout :heading="__('Profilo')" :subheading="__('Aggiorna i tuoi dati e la mail')">
            <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">

                <div class="flex flex-col justify-center items-center mb-10 mt-5">
                    <div class="text-sm text-gray-600">
                        <div class="space-y-2">
                            <figure
                                class="w-[150px] h-[150px] flex items-center justify-center overflow-hidden border rounded-full">
                                @if ($img_url && !is_string($img_url))
                                    {{-- Preview temporanea Livewire --}}
                                    <img src="{{ $img_url->temporaryUrl() }}"
                                        class="w-full h-full object-cover object-top bg-gray-100 dark:bg-[#4b4b4b] opacity-100"
                                        alt="Anteprima immagine">
                                @elseif ($img_url)
                                    {{-- Immagine già salvata --}}
                                    <img src="{{ asset('storage/' . $img_url) }}"
                                        class="w-full h-full object-cover object-top bg-gray-100 dark:bg-[#4b4b4b] opacity-100"
                                        alt="Immagine profilo">
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-10">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                    </svg>
                                @endif
                            </figure>
                        </div>
                    </div>
                    <div class="flex flex-col items-center mt-5">
                        <label for="image_upload" class="mb-2">Carica Immagine</label>
                        <div class="relative group">
                            <input type="file" id="image_upload" name="image_upload"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*"
                                wire:model="img_url">
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

                <flux:input wire:model="name" :label="__('Nome')" type="text" required autofocus
                    autocomplete="name" />

                <flux:input wire:model="surname" :label="__('Cognome')" type="text" required autofocus
                    autocomplete="surname" />

                <div>
                    <flux:input wire:model="email" :label="__('Email')" type="email" required
                        autocomplete="email" />


                    @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                        <div>
                            <flux:text class="mt-4">
                                {{ __('Your email address is unverified.') }}

                                <flux:link class="text-sm cursor-pointer"
                                    wire:click.prevent="resendVerificationNotification">
                                    {{ __('Click here to re-send the verification email.') }}
                                </flux:link>
                            </flux:text>

                            @if (session('status') === 'verification-link-sent')
                                <flux:text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                                    {{ __('A new verification link has been sent to your email address.') }}
                                </flux:text>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="flex items-center gap-4">
                    <div class="flex items-center justify-end">
                        <flux:button variant="primary" type="submit" class="w-full cursor-pointer">{{ __('Salva') }}</flux:button>
                    </div>

                    <x-action-message class="me-3" on="profile-updated">
                        {{ __('Salvato Correttamente') }}
                    </x-action-message>
                </div>
            </form>
            <livewire:settings.delete-user-form />
        </x-settings.layout>
    </div>
</section>
