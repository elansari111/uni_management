@extends('layouts.guest')

@section('content')
<div class="w-full max-w-lg mx-auto bg-[rgba(20,15,40,0.9)] rounded-3xl border border-purple-500/20 p-10 shadow-[0_0_50px_rgba(139,92,246,0.15)]">
    <!-- Branding -->
    <div class="text-center mb-10">
        <div class="inline-flex items-center justify-center gap-2 mb-6">
            <!-- Votre logo doit être placé dans le dossier : public/images/logo.png -->
            <img src="{{ asset('images/logo.png') }}" alt="SMART UPF" class="w-32 h-32 object-contain">
            
            <div class="text-left">
                <div class="font-black text-4xl leading-none text-white tracking-tight">SMART</div>
                <div class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-blue-400 text-2xl font-bold leading-tight">UPF</div>
            </div>
        </div>
        <h1 class="text-3xl font-bold mb-2 text-white">Connexion</h1>
        <p class="text-gray-400">Accédez à votre espace SMART UPF</p>
        <div class="w-24 h-1 bg-gradient-to-r from-purple-600 to-blue-600 rounded-full mt-6 mx-auto"></div>
    </div>

    @if(session('status'))
        <div class="mb-6 text-sm text-green-400 bg-green-500/10 border border-green-500/20 px-4 py-3 rounded-xl">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-6">
            <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full pl-12 pr-4 py-4 bg-[rgba(30,25,50,0.8)] border border-gray-700/50 rounded-2xl text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition" placeholder="votre.email@university.fr">
            </div>
            @error('email')
                <p class="text-red-400 text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-8">
            <label for="password" class="block text-sm font-medium text-gray-300 mb-2">Mot de passe</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <input id="password" type="password" name="password" required
                    class="w-full pl-12 pr-12 py-4 bg-[rgba(30,25,50,0.8)] border border-gray-700/50 rounded-2xl text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition" placeholder="••••••••">
                <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-500 hover:text-gray-300 transition">
                    <svg id="eye-icon" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
            @error('password')
                <p class="text-red-400 text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between mb-8">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-600 bg-gray-800 text-purple-600 focus:ring-purple-500">
                <span class="text-sm text-gray-400">Se souvenir de moi</span>
            </label>
            
            @if(Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-purple-500 hover:text-purple-400 transition font-medium">
                    Mot de passe oublié ?
                </a>
            @endif
        </div>

        <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-500 hover:to-blue-500 text-white font-semibold py-4 rounded-2xl transition-all duration-300 shadow-lg shadow-purple-500/25 transform hover:scale-[1.02] active:scale-[0.98]">
            Se connecter
            <span class="ml-2">→</span>
        </button>
    </form>

    <div class="mt-10">
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-700/50"></div>
            </div>
            <div class="relative flex justify-center text-xs uppercase">
                <span class="bg-[rgba(20,15,40,0.9)] px-4 text-gray-500">ou continuer avec</span>
            </div>
        </div>

        <div class="mt-6">
            <button type="button" class="w-full flex items-center justify-center gap-3 bg-[rgba(30,25,50,0.8)] border border-gray-700/50 hover:bg-[rgba(40,35,60,0.9)] text-gray-300 font-medium py-4 rounded-2xl transition-all duration-300 hover:border-purple-500/50">
                <svg class="w-6 h-6 text-purple-400" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2L14.4 8.4L21 9.3L16.2 13.8L17.4 21L12 17.5L6.6 21L7.8 13.8L3 9.3L9.6 8.4L12 2Z"/>
                </svg>
                Université UPF
            </button>
        </div>
    </div>
</div>

<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
            `;
        } else {
            passwordInput.type = 'password';
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            `;
        }
    }
</script>
@endsection