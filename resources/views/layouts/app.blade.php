<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@hasSection('title') @yield('title') | @endif {{ config('app.name', 'PFM') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
    <style>
        .dark body, .dark .app-container {
            background: #1a1a2e;
            color: #eee;
        }
        .dark .sidebar {
            background: #16213e;
        }
        .dark .main-header-glass {
            background: rgba(22,33,62,0.9);
            border-bottom: 1px solid #2a3f5f;
        }
        .dark .bg-white {
            background: #16213e !important;
        }
        .dark .border-slate-100 {
            border-color: #2a3f5f !important;
        }
        .dark .text-slate-900 {
            color: #eee !important;
        }
        .dark .text-slate-700 {
            color: #ddd !important;
        }
        .dark .text-slate-500 {
            color: #aaa !important;
        }
        .dark .text-indigo-600 {
            color: #818cf8;
        }
        .dark .bg-slate-50 {
            background: #0f172a;
        }
    </style>
</head>
<body>
    <div class="app-container">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <div class="brand-icon">P</div>
                <div>
                    <h2 class="font-extrabold text-xl leading-tight">SMART</h2>
                    <p class="text-sm font-semibold text-indigo-400">UPF</p>
                </div>
            </div>

            <nav class="sidebar-nav">
                @if(Auth::check())
                    @if(Auth::user()->hasRole('admin'))
                        <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <span class="icon">🏠</span>
                            <span>Tableau de bord</span>
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <span class="icon">👥</span>
                            <span>Utilisateurs</span>
                        </a>
                        <a href="{{ route('admin.modules.index') }}" class="sidebar-link {{ request()->routeIs('admin.modules.*') ? 'active' : '' }}">
                            <span class="icon">📚</span>
                            <span>Modules</span>
                        </a>
                        <a href="{{ route('admin.groups.index') }}" class="sidebar-link {{ request()->routeIs('admin.groups.*') ? 'active' : '' }}">
                            <span class="icon">🧩</span>
                            <span>Groupes</span>
                        </a>
                        <a href="{{ route('admin.levels.index') }}" class="sidebar-link {{ request()->routeIs('admin.levels.*') ? 'active' : '' }}">
                            <span class="icon">🎓</span>
                            <span>Niveaux</span>
                        </a>
                        <a href="{{ route('admin.classrooms.index') }}" class="sidebar-link {{ request()->routeIs('admin.classrooms.*') ? 'active' : '' }}">
                            <span class="icon">🏫</span>
                            <span>Salles</span>
                        </a>
                        <a href="{{ route('admin.schedules.index') }}" class="sidebar-link {{ request()->routeIs('admin.schedules.*') ? 'active' : '' }}">
                            <span class="icon">📅</span>
                            <span>Emplois du temps</span>
                        </a>
                        <a href="{{ route('admin.lesson-logs.index') }}" class="sidebar-link {{ request()->routeIs('admin.lesson-logs.*') ? 'active' : '' }}">
                            <span class="icon">📖</span>
                            <span>Cahier de textes</span>
                        </a>
                        <a href="{{ route('admin.reservations') }}" class="sidebar-link {{ request()->routeIs('admin.reservations') || request()->routeIs('admin.requests.reservations') ? 'active' : '' }}">
                            <span class="icon">📋</span>
                            <span>Réservations</span>
                        </a>
                        <a href="{{ route('admin.requests.documents') }}" class="sidebar-link {{ request()->routeIs('admin.requests.documents') ? 'active' : '' }}">
                            <span class="icon">📝</span>
                            <span>Demandes</span>
                        </a>
                        <a href="{{ route('admin.requests.absences') }}" class="sidebar-link {{ request()->routeIs('admin.requests.absences') ? 'active' : '' }}">
                            <span class="icon">🔔</span>
                            <span>Absences</span>
                        </a>
                    @elseif(Auth::user()->hasRole('teacher'))
                        <a href="{{ route('teacher.dashboard') }}" class="sidebar-link {{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}">
                            <span class="icon">🏠</span>
                            <span>Tableau de bord</span>
                        </a>
                        <a href="{{ route('teacher.schedule') }}" class="sidebar-link {{ request()->routeIs('teacher.schedule') ? 'active' : '' }}">
                            <span class="icon">📅</span>
                            <span>Mon EDT</span>
                        </a>
                        <a href="{{ route('teacher.modules') }}" class="sidebar-link {{ request()->routeIs('teacher.modules') ? 'active' : '' }}">
                            <span class="icon">📚</span>
                            <span>Modules</span>
                        </a>
                        <a href="{{ route('teacher.grades.index') }}" class="sidebar-link {{ request()->routeIs('teacher.grades.*') ? 'active' : '' }}">
                            <span class="icon">📊</span>
                            <span>Notes</span>
                        </a>
                        <a href="{{ route('teacher.attendance.index') }}" class="sidebar-link {{ request()->routeIs('teacher.attendance.*') ? 'active' : '' }}">
                            <span class="icon">✅</span>
                            <span>Présences</span>
                        </a>
                        <a href="{{ route('teacher.lesson-logs.index') }}" class="sidebar-link {{ request()->routeIs('teacher.lesson-logs.*') ? 'active' : '' }}">
                            <span class="icon">📖</span>
                            <span>Journal de cours</span>
                        </a>
                        <a href="{{ route('teacher.reservations.index') }}" class="sidebar-link {{ request()->routeIs('teacher.reservations.*') ? 'active' : '' }}">
                            <span class="icon">📋</span>
                            <span>Réservations</span>
                        </a>
                        <a href="{{ route('teacher.requests.index') }}" class="sidebar-link {{ request()->routeIs('teacher.requests.*') ? 'active' : '' }}">
                            <span class="icon">📝</span>
                            <span>Demandes</span>
                        </a>
                    @elseif(Auth::user()->hasRole('student'))
                        <a href="{{ route('student.dashboard') }}" class="sidebar-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                            <span class="icon">🏠</span>
                            <span>Tableau de bord</span>
                        </a>
                        <a href="{{ route('student.modules.index') }}" class="sidebar-link {{ request()->routeIs('student.modules.*') || request()->routeIs('student.classroom.*') ? 'active' : '' }}">
                            <span class="icon">📚</span>
                            <span>Modules</span>
                        </a>
                        <a href="{{ route('student.schedule') }}" class="sidebar-link {{ request()->routeIs('student.schedule') ? 'active' : '' }}">
                            <span class="icon">📅</span>
                            <span>Mon EDT</span>
                        </a>
                        <a href="{{ route('student.grades') }}" class="sidebar-link {{ request()->routeIs('student.grades') || request()->routeIs('student.grades.index') ? 'active' : '' }}">
                            <span class="icon">📊</span>
                            <span>Mes notes</span>
                        </a>
                        <a href="{{ route('student.absences') }}" class="sidebar-link {{ request()->routeIs('student.absences') ? 'active' : '' }}">
                            <span class="icon">🔔</span>
                            <span>Mes absences</span>
                        </a>
                        <a href="{{ route('student.requests') }}" class="sidebar-link {{ request()->routeIs('student.requests') ? 'active' : '' }}">
                            <span class="icon">📝</span>
                            <span>Demandes</span>
                        </a>
                    @endif
                @endif
            </nav>

            <!-- Sidebar Footer -->
            @if(Auth::check())
                <div class="sidebar-footer">
                    <div class="sidebar-user-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-sm">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-400">{{ Auth::user()->role?->name ?? 'Utilisateur' }}</p>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="flex items-center">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors duration-200" title="Se déconnecter">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            @endif
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Glass Header -->
            <div class="main-header-glass">
                <div>
                    <p class="text-xs font-semibold tracking-wider uppercase text-purple-400 mb-1">
                        Bonjour, <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-400 font-bold">{{ Auth::user()->name }}</span> 👋
                    </p>
                    <h1 class="text-2xl font-extrabold tracking-tight">
                        @yield('header_title', 'Tableau de bord')
                    </h1>
                </div>

                <div class="header-actions-glass">
            <!-- Language Switcher -->
            <div class="flex items-center gap-2">
                <a href="{{ route('locale.switch', 'fr') }}" class="text-sm hover:text-indigo-600 transition">🇫🇷</a>
                <a href="{{ route('locale.switch', 'en') }}" class="text-sm hover:text-indigo-600 transition">🇬🇧</a>
                <a href="{{ route('locale.switch', 'ar') }}" class="text-sm hover:text-indigo-600 transition">🇸🇦</a>
            </div>
            
            <!-- Theme Toggle -->
            <button id="theme-toggle" class="p-2 rounded-full hover:bg-slate-100 dark:hover:bg-slate-700 transition" title="Toggle Theme">
                <span id="theme-icon">🌙</span>
            </button>
            
            <!-- Search Bar -->
            <div class="search-container-glass">
                <span class="search-icon-glass">🔍</span>
                <input type="text" placeholder="Rechercher..." class="search-input-glass">
                <span class="search-shortcut">⌘ K</span>
            </div>

            <!-- Notification Button -->
            <button class="notify-btn-glass" title="Notifications">
                <span>🔔</span>
                <span class="notify-badge-glass"></span>
            </button>
        </div>
            </div>

            @yield('content')
        </main>
    </div>

    <script>
        // Mobile sidebar toggle (if needed)
        window.toggleSidebar = function() {
            document.getElementById('sidebar').classList.toggle('open');
        };
        
        // Theme Toggle
        document.getElementById('theme-toggle').addEventListener('click', function() {
            document.documentElement.classList.toggle('dark');
            
            if (document.documentElement.classList.contains('dark')) {
                localStorage.setItem('theme', 'dark');
                document.getElementById('theme-icon').textContent = '☀️';
            } else {
                localStorage.setItem('theme', 'light');
                document.getElementById('theme-icon').textContent = '🌙';
            }
        });
        
        // Initialize theme icon
        if (document.documentElement.classList.contains('dark')) {
            document.getElementById('theme-icon').textContent = '☀️';
        }
    </script>
    @stack('scripts')
</body>
</html>
