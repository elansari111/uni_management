@extends('layouts.guest')

@section('content')
    <div class="mb-8 text-center">
        <div class="mx-auto h-20 w-20 bg-green-100 rounded-full flex items-center justify-center mb-6">
            <svg class="h-10 w-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
        </div>
        <h2 class="text-3xl font-extrabold text-gray-800 mb-2">Vérifiez votre e-mail</h2>
        <p class="text-gray-500">Nous avons envoyé un lien de vérification à votre adresse e-mail</p>
    </div>

    <div class="mb-4 text-sm text-gray-600 bg-blue-50 border-l-4 border-blue-400 p-4 rounded-lg">
        {{ __('Avant de continuer, veuillez vérifier votre e-mail pour le lien de vérification. Si vous n\'avez pas reçu l\'e-mail, nous pouvons vous en renvoyer un.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 text-sm font-medium text-green-600 bg-green-50 border-l-4 border-green-400 p-4 rounded-lg">
            {{ __('Un nouveau lien de vérification a été envoyé à l\'adresse e-mail que vous avez fournie.') }}
        </div>
    @endif

    <div class="flex items-center justify-between mt-8 space-x-4">
        <form method="POST" action="{{ route('verification.send') }}" class="flex-1">
            @csrf
            <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-3 px-4 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all">
                {{ __('Renvoyer l\'e-mail') }}
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="px-4 py-3 text-gray-600 hover:text-gray-800 border border-gray-300 rounded-xl transition">
                {{ __('Se déconnecter') }}
            </button>
        </form>
    </div>
@endsection