<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'PFM') }} - Plateforme de Formation Management</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="min-h-screen bg-gradient-to-br from-[#0a0e27] to-[#1a1440] text-white">
        <!-- Header -->
        <header class="px-8 py-6 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="bg-gradient-to-r from-blue-500 to-purple-600 w-12 h-12 rounded-xl flex items-center justify-center font-extrabold text-2xl shadow-lg shadow-purple-500/30">
                    P
                </div>
                <div>
                    <div class="font-extrabold text-xl leading-tight">SMART</div>
                    <div class="text-purple-400 text-sm font-semibold">UPF</div>
                </div>
            </div>
            <div class="flex items-center gap-4">
                @if(Route::has('login'))
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                            Accéder à l'application
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-2.5 border border-gray-600 rounded-xl text-gray-300 hover:bg-gray-800 transition">
                            Se connecter
                        </a>
                        @if(Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-primary">
                                Commencer
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </header>

        <!-- Main Content -->
        <main class="container mx-auto px-8 py-16">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <!-- Text Section -->
                <div>
                    <div class="mb-6">
                        <span class="text-xs font-bold uppercase tracking-widest text-purple-400 border border-purple-500/30 px-4 py-1.5 rounded-full">
                            PLATEFORME INTELLIGENTE
                        </span>
                    </div>

                    <h1 class="text-5xl lg:text-6xl font-bold leading-tight mb-6">
                        Une gestion
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-blue-400"> intelligente</span>
                        pour une formation
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400"> performante</span>
                    </h1>

                    <p class="text-gray-400 text-lg mb-10 max-w-xl">
                        Simplifiez la gestion de vos formations, étudiants et professeurs avec une plateforme complète et intuitive.
                    </p>

                    <div class="flex flex-wrap gap-4">
                        @if(Route::has('login'))
                            @auth
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary text-base py-3.5">
                                    Accéder à l'application
                                    <span class="ml-2">→</span>
                                </a>
                            @else
                                <a href="{{ route('register') }}" class="btn btn-primary text-base py-3.5">
                                    Découvrir la plateforme
                                    <span class="ml-2">→</span>
                                </a>
                                <a href="{{ route('login') }}" class="btn btn-secondary text-base py-3.5">
                                    En savoir plus
                                </a>
                            @endauth
                        @endif
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-6 mt-12">
                        <div class="text-center p-4 rounded-xl bg-white/5 border border-white/10">
                            <div class="text-3xl font-bold text-purple-400">📚</div>
                            <div class="mt-2 text-sm text-gray-400">Gestion des modules</div>
                        </div>
                        <div class="text-center p-4 rounded-xl bg-white/5 border border-white/10">
                            <div class="text-3xl font-bold text-blue-400">👥</div>
                            <div class="mt-2 text-sm text-gray-400">Gestion des utilisateurs</div>
                        </div>
                        <div class="text-center p-4 rounded-xl bg-white/5 border border-white/10">
                            <div class="text-3xl font-bold text-purple-400">📅</div>
                            <div class="mt-2 text-sm text-gray-400">Emplois du temps</div>
                        </div>
                    </div>
                </div>

                <!-- Visual Section -->
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-500/20 to-blue-500/20 rounded-3xl blur-3xl"></div>
                    <div class="relative card card-glow rounded-3xl border border-purple-500/20">
                        <div class="text-center py-20">
                            <div class="text-9xl mb-6">📊</div>
                            <p class="text-2xl font-bold mb-2">SMART UPF</p>
                            <p class="text-gray-400">La solution complète</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="px-8 py-10 border-t border-white/10 text-center text-gray-500">
            <p>© {{ date('Y') }} {{ config('app.name', 'PFM') }}. Tous droits réservés.</p>
        </footer>
    </div>
</body>
</html>
