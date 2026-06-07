@extends('layouts.guest')

@section('content')
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-extrabold text-gray-800 mb-2">Créer un compte</h2>
        <p class="text-gray-500">Rejoignez la plateforme PFM</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nom complet')" class="text-gray-700 font-medium" />
            <x-text-input id="name" class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition" type="text" name="name" :value="old('name')" required autofocus placeholder="Jean Dupont" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Adresse e-mail')" class="text-gray-700 font-medium" />
            <x-text-input id="email" class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition" type="email" name="email" :value="old('email')" required placeholder="exemple@universite.fr" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Mot de passe')" class="text-gray-700 font-medium" />
            <x-text-input id="password" class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition" type="password" name="password" required autocomplete="new-password" placeholder="Au moins 8 caractères" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" class="text-gray-700 font-medium" />
            <x-text-input id="password_confirmation" class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Répétez le mot de passe" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-3 px-4 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all">
            {{ __('Créer le compte') }}
        </button>
    </form>

    <div class="mt-8 text-center">
        <p class="text-gray-500 text-sm">
            {{ __("Déjà un compte ?") }}
            <a href="{{ route('login') }}" class="text-indigo-600 font-semibold hover:text-indigo-800 transition">
                {{ __('Se connecter') }}
            </a>
        </p>
    </div>
@endsection