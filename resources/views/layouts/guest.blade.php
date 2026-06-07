<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'PFM') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        .auth-container {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 450px;
        }
        .auth-hero {
            padding: 3rem;
            background: radial-gradient(circle at 30% 30%, #151030 0%, var(--bg-primary) 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .auth-form {
            padding: 3rem;
            background: rgba(13, 11, 33, 0.85);
            backdrop-filter: blur(20px);
            border-left: 1px solid rgba(139, 92, 246, 0.25);
            display: flex;
            align-items: center;
            box-shadow: -10px 0 30px rgba(0, 0, 0, 0.25);
        }
        @media (max-width: 1024px) {
            .auth-container {
                grid-template-columns: 1fr;
            }
            .auth-hero {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <!-- Hero Section -->
        <div class="auth-hero">
            <!-- Top Grid: Text on left, 3D/Dashboard Graphic on right -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center mb-12">
                <div>
                    <div class="mb-5">
                        <span class="text-xs font-bold uppercase tracking-widest text-purple-400 border border-purple-500/30 px-3 py-1.5 rounded-full">
                            PLATEFORME INTELLIGENTE
                        </span>
                    </div>
                    
                    <h1 class="text-4xl font-extrabold mb-4 leading-tight text-white">
                        Une gestion <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-blue-400">intelligente</span> pour une formation <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400">performante</span>
                    </h1>
                    
                    <p class="text-gray-400 mb-8 text-sm leading-relaxed max-w-md">
                        Simplifiez la gestion de vos formations, étudiants et professeurs avec une plateforme complète et intuitive.
                    </p>

                    <div class="flex gap-4">
                        <a href="{{ route('register') }}" class="btn btn-primary text-sm py-3 px-6">Découvrir la plateforme &rarr;</a>
                        <a href="#about" class="btn btn-secondary text-sm py-3 px-6">En savoir plus</a>
                    </div>
                </div>

                <!-- 3D Isometric / Glowing Dashboard Mockup Graphic -->
                <div class="relative flex justify-center items-center">
                    <div class="absolute w-72 h-72 bg-gradient-to-br from-purple-500/20 to-blue-500/20 rounded-full blur-3xl"></div>
                    <div class="relative p-6 rounded-2xl border border-purple-500/30 bg-slate-900/40 backdrop-blur-md shadow-2xl transform hover:rotate-1 hover:scale-105 transition duration-500">
                        <div class="text-center py-10 px-8">
                            <div class="text-7xl mb-4 filter drop-shadow-[0_0_15px_rgba(168,85,247,0.5)]">📊</div>
                            <p class="text-xl font-bold tracking-wider text-white">SMART UPF</p>
                            <p class="text-xs text-purple-400 mt-1">La solution complète</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Row: Three Feature Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="card p-5 flex flex-col justify-between">
                    <div>
                        <div class="text-purple-400 mb-3 text-2xl">📚</div>
                        <h3 class="font-bold text-sm mb-1 text-white">Gestion des modules</h3>
                        <p class="text-xs text-gray-400">Organisez et gérez tous vos cours et programmes de formation.</p>
                    </div>
                </div>
                
                <div class="card p-5 flex flex-col justify-between">
                    <div>
                        <div class="text-blue-400 mb-3 text-2xl">👥</div>
                        <h3 class="font-bold text-sm mb-1 text-white">Gestion des utilisateurs</h3>
                        <p class="text-xs text-gray-400">Gerez les etudiants, professeurs et administrateurs en un seul endroit.</p>
                    </div>
                </div>
                
                <div class="card p-5 flex flex-col justify-between">
                    <div>
                        <div class="text-purple-400 mb-3 text-2xl">📅</div>
                        <h3 class="font-bold text-sm mb-1 text-white">Emplois du temps</h3>
                        <p class="text-xs text-gray-400">Planifiez et consultez les horaires des cours facilement.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Form Section -->
        <div class="auth-form">
            <div class="w-full">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
