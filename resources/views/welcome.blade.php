<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'PFM') }} - Plateforme de Formation Management</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px) translateX(0px); }
            25% { transform: translateY(-20px) translateX(10px); }
            50% { transform: translateY(-10px) translateX(-10px); }
            75% { transform: translateY(-30px) translateX(5px); }
        }
        
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(139, 92, 246, 0.3); }
            50% { box-shadow: 0 0 40px rgba(139, 92, 246, 0.6); }
        }
        
        @keyframes slide-up {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes gradient-shift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        @keyframes shimmer {
            0% { background-position: -200% center; }
            100% { background-position: 200% center; }
        }
        
        @keyframes bounce-slow {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        @keyframes rotate-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-float-delay-1 { animation: float 6s ease-in-out infinite; animation-delay: -2s; }
        .animate-float-delay-2 { animation: float 6s ease-in-out infinite; animation-delay: -4s; }
        .animate-pulse-glow { animation: pulse-glow 3s ease-in-out infinite; }
        .animate-slide-up { animation: slide-up 0.8s ease-out forwards; }
        .animate-gradient-shift { background-size: 200% 200%; animation: gradient-shift 4s ease infinite; }
        .animate-bounce-slow { animation: bounce-slow 3s ease-in-out infinite; }
        .animate-rotate-slow { animation: rotate-slow 20s linear infinite; }
        
        .glass-strong {
            background: rgba(10, 14, 39, 0.8);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .gradient-border {
            position: relative;
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.2), rgba(59, 130, 246, 0.2));
        }
        
        .gradient-border::before {
            content: '';
            position: absolute;
            inset: -1px;
            border-radius: inherit;
            padding: 1px;
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.5), rgba(59, 130, 246, 0.5), rgba(139, 92, 246, 0.5));
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
        }
        
        .text-gradient {
            background: linear-gradient(135deg, #a78bfa 0%, #60a5fa 50%, #a78bfa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .btn-primary-glow {
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #7c3aed, #4f46e5, #7c3aed);
            background-size: 200% 200%;
            animation: gradient-shift 3s ease infinite;
        }
        
        .btn-primary-glow::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: 0.5s;
        }
        
        .btn-primary-glow:hover::before {
            left: 100%;
        }
        
        .feature-card {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        .feature-card:hover {
            transform: translateY(-8px) scale(1.02);
        }
        
        .feature-icon {
            transition: all 0.3s ease;
        }
        
        .feature-card:hover .feature-icon {
            transform: scale(1.1) rotate(5deg);
        }
        
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.6;
        }
        
        .stagger-1 { animation-delay: 0.1s; }
        .stagger-2 { animation-delay: 0.2s; }
        .stagger-3 { animation-delay: 0.3s; }
        .stagger-4 { animation-delay: 0.4s; }
        
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }
        
        .shimmer-text {
            background: linear-gradient(90deg, #a78bfa, #60a5fa, #a78bfa);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: shimmer 3s linear infinite;
        }
        
        .noise-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            opacity: 0.03;
            z-index: 100;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)'/%3E%3C/svg%3E");
        }
    </style>
</head>
<body class="min-h-screen antialiased">
    <div class="noise-overlay"></div>
    
    <div class="min-h-screen bg-gradient-to-br from-[#020617] via-[#0a0e27] to-[#1a1440] text-white relative overflow-hidden">
        <!-- Background Orbs -->
        <div class="orb w-96 h-96 bg-purple-600/30 -top-48 -left-48 animate-float"></div>
        <div class="orb w-80 h-80 bg-blue-600/30 top-1/3 -right-40 animate-float-delay-1"></div>
        <div class="orb w-64 h-64 bg-violet-600/30 bottom-20 left-1/4 animate-float-delay-2"></div>
        
        <!-- Decorative Elements -->
        <div class="absolute top-1/4 right-10 w-2 h-2 rounded-full bg-purple-400 animate-bounce-slow"></div>
        <div class="absolute top-1/2 left-10 w-3 h-3 rounded-full bg-blue-400 animate-bounce-slow" style="animation-delay: -1s;"></div>
        <div class="absolute bottom-1/3 right-20 w-2 h-2 rounded-full bg-violet-400 animate-bounce-slow" style="animation-delay: -2s;"></div>

        <!-- Header -->
        <header class="px-6 lg:px-12 py-6 flex items-center justify-between relative z-10 max-w-7xl mx-auto animate-slide-up">
            <div class="flex items-center gap-3 group cursor-pointer">
                <div class="relative">
                    <div class="absolute inset-0 bg-purple-500/30 rounded-2xl blur-lg group-hover:bg-purple-500/50 transition-all duration-300"></div>
                    <img src="{{ asset('images/logo.png') }}" alt="SMART UPF" class="w-12 h-12 object-contain relative z-10">
                </div>
                <div>
                    <div class="font-extrabold text-xl leading-tight tracking-tight">SMART</div>
                    <div class="shimmer-text text-sm font-bold tracking-wide">UPF</div>
                </div>
            </div>
            
            <nav class="hidden lg:flex items-center gap-8">
                <a href="#" class="text-sm font-semibold text-purple-400 relative group">
                    Accueil
                    <span class="absolute -bottom-1 left-0 w-full h-0.5 bg-gradient-to-r from-purple-400 to-blue-400 rounded-full"></span>
                </a>
                <a href="#features" class="text-sm font-medium text-gray-400 hover:text-white transition-colors duration-300 relative group">
                    Fonctionnalités
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-gradient-to-r from-purple-400 to-blue-400 rounded-full group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="#modules" class="text-sm font-medium text-gray-400 hover:text-white transition-colors duration-300 relative group">
                    Modules
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-gradient-to-r from-purple-400 to-blue-400 rounded-full group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="#about" class="text-sm font-medium text-gray-400 hover:text-white transition-colors duration-300 relative group">
                    À propos
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-gradient-to-r from-purple-400 to-blue-400 rounded-full group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="#contact" class="text-sm font-medium text-gray-400 hover:text-white transition-colors duration-300 relative group">
                    Contact
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-gradient-to-r from-purple-400 to-blue-400 rounded-full group-hover:w-full transition-all duration-300"></span>
                </a>
            </nav>
            
            <div class="flex items-center gap-4">
                @if(Route::has('login'))
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="btn-primary-glow px-6 py-3 rounded-xl font-semibold text-sm shadow-lg shadow-purple-500/25 hover:shadow-purple-500/40 transition-all duration-300">
                            Accéder à l'application
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-2.5 text-sm font-semibold text-gray-300 hover:text-white transition-all duration-300 flex items-center gap-2 hover:bg-white/5 rounded-xl">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Se connecter
                        </a>
                        <a href="{{ route('login') }}" class="btn-primary-glow px-6 py-3 rounded-xl font-semibold text-sm shadow-lg shadow-purple-500/25 hover:shadow-purple-500/40 transition-all duration-300">
                            Commencer
                            <span class="ml-1">→</span>
                        </a>
                    @endauth
                @endif
            </div>
        </header>

        <!-- Hero Section -->
        <main class="relative z-10">
            <div class="max-w-7xl mx-auto px-6 lg:px-12 py-16 lg:py-24">
                <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
                    <!-- Text Section -->
                    <div class="animate-slide-up stagger-1">
                        <div class="mb-8 inline-flex items-center gap-2 px-4 py-2 rounded-full bg-gradient-to-r from-purple-500/10 to-blue-500/10 border border-purple-500/20 backdrop-blur-sm">
                            <div class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></div>
                            <span class="text-xs font-bold uppercase tracking-widest text-purple-300">Plateforme intelligente</span>
                        </div>

                        <h1 class="text-4xl md:text-5xl lg:text-7xl font-black leading-tight mb-8 tracking-tight">
                            Gérez votre établissement
                            <span class="block mt-4">
                                <span class="text-gradient">avec simplicité</span>
                            </span>
                            <span class="block mt-2">
                                et <span class="text-gradient">efficacité</span>
                            </span>
                        </h1>

                        <p class="text-gray-400 text-lg md:text-xl leading-relaxed mb-10 max-w-lg">
                            Centralisez la gestion des étudiants, enseignants, modules, emplois du temps, notes et évaluations dans une seule plateforme intuitive et performante.
                        </p>

                        <div class="flex flex-col sm:flex-row gap-4 mb-12">
                            @if(Route::has('login'))
                                @auth
                                    <a href="{{ route('admin.dashboard') }}" class="btn-primary-glow px-10 py-5 rounded-2xl font-bold text-lg shadow-2xl shadow-purple-500/30 hover:shadow-purple-500/60 transition-all duration-300 hover-lift text-center group">
                                        Commencer maintenant
                                        <span class="ml-2 inline-block group-hover:translate-x-1 transition-transform">→</span>
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="btn-primary-glow px-10 py-5 rounded-2xl font-bold text-lg shadow-2xl shadow-purple-500/30 hover:shadow-purple-500/60 transition-all duration-300 hover-lift text-center group">
                                        Commencer maintenant
                                        <span class="ml-2 inline-block group-hover:translate-x-1 transition-transform">→</span>
                                    </a>
                                @endauth
                            @endif
                            <button class="px-10 py-5 rounded-2xl font-semibold text-lg text-gray-200 bg-white/5 border border-white/10 hover:bg-white/10 hover:border-white/20 transition-all duration-300 flex items-center justify-center gap-3 hover-lift group">
                                <div class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center group-hover:bg-white/20 transition-all duration-300 group-hover:scale-110">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z" />
                                    </svg>
                                </div>
                                Découvrir la plateforme
                            </button>
                        </div>

                        <!-- Stats -->
                        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                            <div class="glass-strong rounded-2xl p-6 text-center hover-lift animate-slide-up stagger-1 group">
                                <div class="w-12 h-12 mx-auto mb-3 rounded-xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div class="text-4xl font-extrabold text-white mb-1">+5 000</div>
                                <div class="text-sm text-gray-400 font-medium">Étudiants</div>
                            </div>
                            <div class="glass-strong rounded-2xl p-6 text-center hover-lift animate-slide-up stagger-2 group">
                                <div class="w-12 h-12 mx-auto mb-3 rounded-xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div class="text-4xl font-extrabold text-blue-400 mb-1">+250</div>
                                <div class="text-sm text-gray-400 font-medium">Enseignants</div>
                            </div>
                            <div class="glass-strong rounded-2xl p-6 text-center hover-lift animate-slide-up stagger-3 group">
                                <div class="w-12 h-12 mx-auto mb-3 rounded-xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                                <div class="text-4xl font-extrabold text-purple-400 mb-1">+100</div>
                                <div class="text-sm text-gray-400 font-medium">Modules</div>
                            </div>
                            <div class="glass-strong rounded-2xl p-6 text-center hover-lift animate-slide-up stagger-4 group">
                                <div class="w-12 h-12 mx-auto mb-3 rounded-xl bg-green-500/10 border border-green-500/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="text-4xl font-extrabold text-green-400 mb-1">99.9%</div>
                                <div class="text-sm text-gray-400 font-medium">Disponibilité</div>
                            </div>
                        </div>
                    </div>

                    <!-- Visual Section -->
                    <div class="relative animate-slide-up stagger-2">
                        <div class="absolute -top-10 -right-10 w-72 h-72 bg-purple-500/20 rounded-full blur-3xl animate-pulse"></div>
                        <div class="absolute -bottom-10 -left-10 w-72 h-72 bg-blue-500/20 rounded-full blur-3xl animate-pulse" style="animation-delay: -1.5s;"></div>
                        
                        <!-- Modern Dashboard Illustration -->
                        <div class="relative glass-strong rounded-3xl p-8 overflow-hidden group hover:scale-[1.02] transition-all duration-500">
                            <!-- Top Bar -->
                            <div class="flex items-center gap-2 mb-6">
                                <div class="w-3 h-3 rounded-full bg-red-400/60"></div>
                                <div class="w-3 h-3 rounded-full bg-yellow-400/60"></div>
                                <div class="w-3 h-3 rounded-full bg-green-400/60"></div>
                            </div>
                            
                            <!-- Stats Grid -->
                            <div class="grid grid-cols-2 gap-3 mb-4">
                                <div class="bg-gradient-to-br from-purple-500/10 to-blue-500/10 rounded-xl p-3 border border-purple-500/20 animate-float">
                                    <div class="text-xs text-gray-400 mb-1">Étudiants</div>
                                    <div class="text-xl font-bold text-white">+1,247</div>
                                </div>
                                <div class="bg-gradient-to-br from-blue-500/10 to-cyan-500/10 rounded-xl p-3 border border-blue-500/20 animate-float-delay-1">
                                    <div class="text-xs text-gray-400 mb-1">Modules</div>
                                    <div class="text-xl font-bold text-white">84</div>
                                </div>
                            </div>
                            
                            <!-- Chart Placeholder -->
                            <div class="bg-white/5 rounded-xl p-4 border border-white/10 mb-4">
                                <div class="flex items-end gap-2 h-20">
                                    <div class="w-1/4 bg-gradient-to-t from-purple-500/30 to-purple-500/70 rounded-t-lg animate-pulse" style="height: 70%;"></div>
                                    <div class="w-1/4 bg-gradient-to-t from-blue-500/30 to-blue-500/70 rounded-t-lg animate-pulse" style="height: 90%; animation-delay: -0.2s;"></div>
                                    <div class="w-1/4 bg-gradient-to-t from-purple-500/30 to-purple-500/70 rounded-t-lg animate-pulse" style="height: 60%; animation-delay: -0.4s;"></div>
                                    <div class="w-1/4 bg-gradient-to-t from-blue-500/30 to-blue-500/70 rounded-t-lg animate-pulse" style="height: 85%; animation-delay: -0.6s;"></div>
                                </div>
                            </div>
                            
                            <!-- Activity List -->
                            <div class="space-y-2">
                                <div class="flex items-center gap-3 bg-white/5 rounded-lg p-2 animate-float-delay-2">
                                    <div class="w-8 h-8 rounded-full bg-purple-500/20 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <div class="text-xs text-white">Nouvelle inscription</div>
                                        <div class="text-[10px] text-gray-400">Il y a 2 min</div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 bg-white/5 rounded-lg p-2">
                                    <div class="w-8 h-8 rounded-full bg-blue-500/20 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <div class="text-xs text-white">Note ajoutée</div>
                                        <div class="text-[10px] text-gray-400">Il y a 5 min</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Floating Elements -->
                        <div class="absolute -top-4 -right-4 glass-strong rounded-xl p-3 animate-float group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <div class="absolute -bottom-4 -left-4 glass-strong rounded-xl p-3 animate-float-delay-1 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Features Section -->
                <section id="features" class="py-24">
                    <div class="text-center mb-16">
                        <span class="text-purple-400 font-semibold text-sm uppercase tracking-wider mb-4 block">Ce que nous offrons</span>
                        <h2 class="text-3xl md:text-4xl font-extrabold mb-4">Une suite complète de fonctionnalités</h2>
                        <p class="text-gray-400 text-base max-w-2xl mx-auto">Tout ce dont vous avez besoin pour gérer votre établissement efficacement</p>
                    </div>
                    
                    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="feature-card glass-strong rounded-2xl p-7 relative overflow-hidden group animate-slide-up stagger-1">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-purple-500/10 rounded-full blur-2xl -translate-y-1/2 translate-x-1/2 group-hover:bg-purple-500/20 transition-all duration-300"></div>
                            <div class="feature-icon w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-500/20 to-purple-600/20 border border-purple-500/30 flex items-center justify-center mb-5 relative z-10">
                                <svg class="w-7 h-7 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <h3 class="font-bold text-lg mb-2 relative z-10">Gestion des étudiants</h3>
                            <p class="text-gray-400 text-sm mb-5 relative z-10">Inscriptions et dossiers étudiants complets</p>
                            <ul class="space-y-2 relative z-10">
                                <li class="flex items-center gap-2 text-xs text-gray-500">
                                    <svg class="w-4 h-4 text-purple-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    Suivi académique
                                </li>
                                <li class="flex items-center gap-2 text-xs text-gray-500">
                                    <svg class="w-4 h-4 text-purple-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    Résultats et relevés
                                </li>
                            </ul>
                        </div>

                        <div class="feature-card glass-strong rounded-2xl p-7 relative overflow-hidden group animate-slide-up stagger-2">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/10 rounded-full blur-2xl -translate-y-1/2 translate-x-1/2 group-hover:bg-blue-500/20 transition-all duration-300"></div>
                            <div class="feature-icon w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500/20 to-blue-600/20 border border-blue-500/30 flex items-center justify-center mb-5 relative z-10">
                                <svg class="w-7 h-7 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <h3 class="font-bold text-lg mb-2 relative z-10">Gestion des enseignants</h3>
                            <p class="text-gray-400 text-sm mb-5 relative z-10">Gestion des cours et affectations</p>
                            <ul class="space-y-2 relative z-10">
                                <li class="flex items-center gap-2 text-xs text-gray-500">
                                    <svg class="w-4 h-4 text-blue-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    Présences et absences
                                </li>
                                <li class="flex items-center gap-2 text-xs text-gray-500">
                                    <svg class="w-4 h-4 text-blue-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    Évaluations et notes
                                </li>
                            </ul>
                        </div>

                        <div class="feature-card glass-strong rounded-2xl p-7 relative overflow-hidden group animate-slide-up stagger-3">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-violet-500/10 rounded-full blur-2xl -translate-y-1/2 translate-x-1/2 group-hover:bg-violet-500/20 transition-all duration-300"></div>
                            <div class="feature-icon w-14 h-14 rounded-2xl bg-gradient-to-br from-violet-500/20 to-violet-600/20 border border-violet-500/30 flex items-center justify-center mb-5 relative z-10">
                                <svg class="w-7 h-7 text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <h3 class="font-bold text-lg mb-2 relative z-10">Gestion des modules</h3>
                            <p class="text-gray-400 text-sm mb-5 relative z-10">Programmes et contenus pédagogiques</p>
                            <ul class="space-y-2 relative z-10">
                                <li class="flex items-center gap-2 text-xs text-gray-500">
                                    <svg class="w-4 h-4 text-violet-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    Organisation des semestres
                                </li>
                                <li class="flex items-center gap-2 text-xs text-gray-500">
                                    <svg class="w-4 h-4 text-violet-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    Planification des cours
                                </li>
                            </ul>
                        </div>

                        <div class="feature-card glass-strong rounded-2xl p-7 relative overflow-hidden group animate-slide-up stagger-4">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-cyan-500/10 rounded-full blur-2xl -translate-y-1/2 translate-x-1/2 group-hover:bg-cyan-500/20 transition-all duration-300"></div>
                            <div class="feature-icon w-14 h-14 rounded-2xl bg-gradient-to-br from-cyan-500/20 to-cyan-600/20 border border-cyan-500/30 flex items-center justify-center mb-5 relative z-10">
                                <svg class="w-7 h-7 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 class="font-bold text-lg mb-2 relative z-10">Emplois du temps</h3>
                            <p class="text-gray-400 text-sm mb-5 relative z-10">Calendriers interactifs intelligents</p>
                            <ul class="space-y-2 relative z-10">
                                <li class="flex items-center gap-2 text-xs text-gray-500">
                                    <svg class="w-4 h-4 text-cyan-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    Gestion interactif
                                </li>
                                <li class="flex items-center gap-2 text-xs text-gray-500">
                                    <svg class="w-4 h-4 text-cyan-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    Notifications et rappels
                                </li>
                            </ul>
                        </div>
                    </div>
                </section>

                <!-- Banner Section -->
                <section id="modules" class="py-8">
                    <div class="grid md:grid-cols-3 gap-6">
                        <div class="glass-strong rounded-2xl p-7 relative overflow-hidden hover-lift group animate-slide-up stagger-1">
                            <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-purple-500/20 to-blue-500/20 rounded-full blur-2xl -translate-y-1/3 translate-x-1/3"></div>
                            <div class="relative z-10 flex items-start gap-5">
                                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-purple-500/20 to-blue-500/20 border border-purple-500/30 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-8 h-8 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-lg mb-2">Gestion centralisée</h3>
                                    <p class="text-gray-400 text-sm mb-4">Toutes les données en même endroit, accessibles rapidement</p>
                                    <a href="#" class="text-purple-400 text-sm font-semibold hover:text-purple-300 transition-colors inline-flex items-center gap-1 group/link">
                                        En savoir plus
                                        <svg class="w-4 h-4 group-hover/link:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="glass-strong rounded-2xl p-7 relative overflow-hidden hover-lift group animate-slide-up stagger-2">
                            <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-blue-500/20 to-purple-500/20 rounded-full blur-2xl -translate-y-1/3 translate-x-1/3"></div>
                            <div class="relative z-10 flex items-start gap-5">
                                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500/20 to-purple-500/20 border border-blue-500/30 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-8 h-8 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-lg mb-2">Suivi en temps réel</h3>
                                    <p class="text-gray-400 text-sm mb-4">Analysez les performances et prenez des décisions datées au bon moment</p>
                                    <a href="#" class="text-blue-400 text-sm font-semibold hover:text-blue-300 transition-colors inline-flex items-center gap-1 group/link">
                                        En savoir plus
                                        <svg class="w-4 h-4 group-hover/link:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="glass-strong rounded-2xl p-7 relative overflow-hidden hover-lift group animate-slide-up stagger-3">
                            <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-violet-500/20 to-blue-500/20 rounded-full blur-2xl -translate-y-1/3 translate-x-1/3"></div>
                            <div class="relative z-10 flex items-start gap-5">
                                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-violet-500/20 to-blue-500/20 border border-violet-500/30 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-8 h-8 text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-lg mb-2">Sécurité renforcée</h3>
                                    <p class="text-gray-400 text-sm mb-4">Vos données sont protégées avec des standards internationaux</p>
                                    <a href="#" class="text-violet-400 text-sm font-semibold hover:text-violet-300 transition-colors inline-flex items-center gap-1 group/link">
                                        En savoir plus
                                        <svg class="w-4 h-4 group-hover/link:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- CTA Section -->
                <section id="about" class="py-16">
                    <div class="relative overflow-hidden rounded-3xl">
                        <div class="absolute inset-0 bg-gradient-to-r from-purple-600/30 via-transparent to-blue-600/30"></div>
                        <div class="absolute -top-40 -left-40 w-80 h-80 bg-purple-500/20 rounded-full blur-3xl"></div>
                        <div class="absolute -bottom-40 -right-40 w-80 h-80 bg-blue-500/20 rounded-full blur-3xl"></div>
                        
                        <div class="glass-strong rounded-3xl p-10 lg:p-14 relative z-10">
                            <div class="flex flex-col lg:flex-row items-center justify-between gap-8">
                                <div class="flex items-center gap-6">
                                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-purple-500/20 to-blue-500/20 border border-purple-500/30 flex items-center justify-center animate-pulse-glow">
                                        <svg class="w-8 h-8 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-2xl lg:text-3xl font-extrabold mb-2">Prêt à moderniser votre établissement ?</h3>
                                        <p class="text-gray-400 text-base">Rejoignez des centaines d'établissements qui ont déjà fait confiance</p>
                                    </div>
                                </div>
                                @if(Route::has('login'))
                                    @auth
                                        <a href="{{ route('admin.dashboard') }}" class="btn-primary-glow px-10 py-4 rounded-2xl font-bold text-base shadow-2xl shadow-purple-500/30 hover:shadow-purple-500/50 transition-all duration-300 hover-lift whitespace-nowrap">
                                            Commencer maintenant
                                            <span class="ml-2 inline-block">→</span>
                                        </a>
                                    @else
                                        <a href="{{ route('login') }}" class="btn-primary-glow px-10 py-4 rounded-2xl font-bold text-base shadow-2xl shadow-purple-500/30 hover:shadow-purple-500/50 transition-all duration-300 hover-lift whitespace-nowrap">
                                            Commencer maintenant
                                            <span class="ml-2 inline-block">→</span>
                                        </a>
                                    @endauth
                                @endif
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </main>

        <!-- Footer -->
        <footer id="contact" class="px-6 lg:px-12 py-16 border-t border-white/10 relative z-10">
            <div class="max-w-7xl mx-auto">
                <div class="grid md:grid-cols-2 lg:grid-cols-5 gap-10 mb-12">
                    <div class="lg:col-span-2">
                        <div class="flex items-center gap-3 mb-5">
                            <img src="{{ asset('images/logo.png') }}" alt="SMART UPF" class="w-10 h-10 object-contain">
                            <div>
                                <div class="font-extrabold text-lg leading-tight">SMART</div>
                                <div class="shimmer-text text-sm font-bold">UPF</div>
                            </div>
                        </div>
                        <p class="text-gray-400 text-sm mb-6 max-w-sm leading-relaxed">La plateforme intelligente pour une gestion efficace de votre établissement. Simplifiez vos processus administratifs et concentrez-vous sur l'essentiel.</p>
                        <div class="flex items-center gap-3">
                            <a href="#" class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 hover:text-white hover:bg-white/10 hover:border-white/20 transition-all duration-300 hover-lift">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 hover:text-white hover:bg-white/10 hover:border-white/20 transition-all duration-300 hover-lift">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 hover:text-white hover:bg-white/10 hover:border-white/20 transition-all duration-300 hover-lift">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                            </a>
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="font-bold text-base mb-5 text-white">Navigation</h4>
                        <ul class="space-y-3">
                            <li><a href="#" class="text-gray-400 text-sm hover:text-white transition-colors duration-300">Accueil</a></li>
                            <li><a href="#features" class="text-gray-400 text-sm hover:text-white transition-colors duration-300">Fonctionnalités</a></li>
                            <li><a href="#modules" class="text-gray-400 text-sm hover:text-white transition-colors duration-300">Modules</a></li>
                            <li><a href="#about" class="text-gray-400 text-sm hover:text-white transition-colors duration-300">À propos</a></li>
                        </ul>
                    </div>
                    
                    <div>
                        <h4 class="font-bold text-base mb-5 text-white">Ressources</h4>
                        <ul class="space-y-3">
                            <li><a href="#" class="text-gray-400 text-sm hover:text-white transition-colors duration-300">Documentation</a></li>
                            <li><a href="#" class="text-gray-400 text-sm hover:text-white transition-colors duration-300">Guides</a></li>
                            <li><a href="#" class="text-gray-400 text-sm hover:text-white transition-colors duration-300">Support</a></li>
                            <li><a href="#" class="text-gray-400 text-sm hover:text-white transition-colors duration-300">Blog</a></li>
                        </ul>
                    </div>
                    
                    <div>
                        <h4 class="font-bold text-base mb-5 text-white">Légal</h4>
                        <ul class="space-y-3">
                            <li><a href="#" class="text-gray-400 text-sm hover:text-white transition-colors duration-300">Politique de confidentialité</a></li>
                            <li><a href="#" class="text-gray-400 text-sm hover:text-white transition-colors duration-300">Conditions d'utilisation</a></li>
                            <li><a href="#" class="text-gray-400 text-sm hover:text-white transition-colors duration-300">Mentions légales</a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="flex flex-col md:flex-row items-center justify-between pt-8 border-t border-white/10">
                    <p class="text-gray-500 text-sm">© {{ date('Y') }} SMART UPF. Tous droits réservés.</p>
                    <p class="text-gray-600 text-sm mt-3 md:mt-0">Fait avec ❤️ pour l'éducation</p>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
