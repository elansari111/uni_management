@extends('layouts.guest')

@section('content')
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-extrabold text-gray-800 mb-2">Réinitialiser le mot de passe</h2>
        <p class="text-gray-500">Choisissez un nouveau mot de passe</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Adresse e-mail')" class="text-gray-700 font-medium" />
            <x-text-input id="email" class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition" type="email" name="email" :value="old('email', $request->email)" required autofocus placeholder="exemple@universite.fr" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Nouveau mot de passe')" class="text-gray-700 font-medium" />
            <x-text-input id="password" class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition" type="password" name="password" required autocomplete="new-password" placeholder="Au moins 8 caractères" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirmer le nouveau mot de passe')" class="text-gray-700 font-medium" />
            <x-text-input id="password_confirmation" class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Répétez le nouveau mot de passe" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-3 px-4 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all">
            {{ __('Réinitialiser le mot de passe') }}
        </button>
    </form>
@endsection