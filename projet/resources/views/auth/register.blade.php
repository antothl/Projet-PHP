<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            <h1 style="color: white; text-align: center; font-size: 1.5em;"><strong>Création d'un compte</strong></h1>
            <br/><hr><br/>
            @csrf

            <div class="mt-4">
                <x-jet-label for="prenom" value="Prenom"  style="color: white;"/>
                <x-jet-input id="prenom" class="block mt-1 w-full" type="text" name="prenom" :value="old('prenom')" required autofocus autocomplete="prenom"  style="background-color: #212529;; color: white; --tw-ring-color: rgb(255 255 255 / .5);"/>
            </div><br/>

            <div class="mt-4">
                <x-jet-label for="nom" value="Nom"  style="color: white;"/>
                <x-jet-input id="nom" class="block mt-1 w-full" type="text" name="nom" :value="old('nom')" required autofocus autocomplete="nom"  style="background-color: #212529;; color: white;--tw-ring-color: rgb(255 255 255 / .5);"/>
            </div><br/>

            <div class="mt-4">
                <x-jet-label for="pseudonyme" value="Pseudonyme" style="color: white;" />
                <x-jet-input id="pseudonyme" class="block mt-1 w-full" type="text" name="pseudonyme" :value="old('pseudonyme')" required autofocus autocomplete="pseudonyme"  style="background-color: #212529;; color: white;--tw-ring-color: rgb(255 255 255 / .5);"/>
            </div><br/>

            <div class="mt-4">
                <x-jet-label for="email" value="Adresse mail"  style="color: white;"/>
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required  style="background-color: #212529;; color: white;--tw-ring-color: rgb(255 255 255 / .5);"/>
            </div><br/>

            <div class="mt-4">
                <x-jet-label for="password" value="Mot de passe"  style="color: white;"/>
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password"  style="background-color: #212529;; color: white;--tw-ring-color: rgb(255 255 255 / .5);"/>
            </div><br/>

            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="Confirmer le mot de passe"  style="color: white;"/>
                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" style="background-color: #212529;; color: white;--tw-ring-color: rgb(255 255 255 / .5);"/>
            </div><br/>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-jet-label for="terms">
                        <div class="flex items-center">
                            <x-jet-checkbox name="terms" id="terms" required />

                            <div class="ml-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-jet-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-white hover:text-gray-900" href="{{ route('login') }}" onMouseOver="this.style.color='#AAAAAA'" onMouseOut="this.style.color='#FFFFFF'">
                    Vous avez déjà un compte?
                </a>

                <x-jet-button class="ml-4" style="background-color: white; color: black;">
                    Valider
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
