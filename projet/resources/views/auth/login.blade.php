<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            <h1 style="color: white; text-align: center; font-size: 1.5em;"><strong>Connexion</strong></h1>
            <br/><hr><br/>
            @csrf

            <div class="mt-4">
                <x-jet-label for="pseudonyme" value="Pseudonyme" style="color: white;"/>
                <x-jet-input id="pseudonyme" class="block mt-1 w-full" type="text" name="pseudonyme" :value="old('pseudonyme')" required autofocus autocomplete="pseudonyme" style="background-color: #212529; color: white; --tw-ring-color: rgb(255 255 255 / .5);"/>
            </div><br/>

    

            <div class="mt-4">
                <x-jet-label for="password" value="Mot de passe" style="color: white;"/>
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password"  style="background-color: #212529;; color: white; --tw-ring-color: rgb(255 255 255 / .5);"/>
            </div><br/>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-white" href="{{ route('register') }}" onMouseOver="this.style.color='#AAAAAA'" onMouseOut="this.style.color='#FFFFFF'">
                    Vous n'avez pas de compte?
                </a>
                <x-jet-button class="ml-4" style="background-color: white; color: black;">
                    Se connecter
                </x-jet-button>
                <br/>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
