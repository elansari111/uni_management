@extends('layouts.guest')

@section('content')
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-extrabold text-gray-800 mb-2">Mot de passe oublié ?</h2>
        <p class="text-gray-500">Entrez votre e-mail pour réinitialiser</p>
    </div>

    <div class="mb-4 text-sm text-gray-600 bg-blue-50 border-l-4 border-blue-400 p-4 rounded-lg">
        {{ __('Pas de problème ! Indiquez-nous votre adresse e-mail et nous vous enverrons un lien de réinitialisation.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Adresse e-mail')" class="text-gray-700 font-medium" />
            <x-text-input id="email" class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition" type="email" name="email" :value="old('email')" required autofocus placeholder="exemple@universite.fr" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-3 px-4 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all">
            {{ __('Envoyer le lien') }}
        </button>
    </form>

    <div class="mt-8 text-center">
        <a href="{{ route('login') }}" class="text-indigo-600 font-semibold hover:text-indigo-800 transition flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            {{ __('Retour à la connexion') }}
        </a>
    </div>
@endsection