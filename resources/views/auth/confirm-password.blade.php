@extends('layouts.guest')

@section('content')
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-extrabold text-gray-800 mb-2">Confirmer le mot de passe</h2>
        <p class="text-gray-500">Veuillez confirmer votre mot de passe avant de continuer</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Mot de passe')" class="text-gray-700 font-medium" />
            <x-text-input id="password" class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-3 px-4 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all">
            {{ __('Confirmer') }}
        </button>
    </form>
@endsection