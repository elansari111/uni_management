<nav class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center text-gray-800">
                        <span class="font-bold text-xl">PFM</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @auth
                        @if(Auth::user()->hasRole('admin'))
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'border-b-2 border-indigo-400 text-gray-900' : 'border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                {{ __('Dashboard') }}
                            </a>
                            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('admin.users.*') ? 'border-b-2 border-indigo-400 text-gray-900' : 'border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                {{ __('Users') }}
                            </a>
                            <a href="{{ route('admin.schedules.index') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('admin.schedules.*') ? 'border-b-2 border-indigo-400 text-gray-900' : 'border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                {{ __('Schedules') }}
                            </a>
                            <a href="{{ route('admin.reservations') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('admin.reservations') || request()->routeIs('admin.requests.reservations') ? 'border-b-2 border-indigo-400 text-gray-900' : 'border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                {{ __('Reservations') }}
                            </a>
                            <a href="{{ route('admin.requests.documents') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('admin.requests.documents') ? 'border-b-2 border-indigo-400 text-gray-900' : 'border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                {{ __('Requests') }}
                            </a>
                            <a href="{{ route('admin.requests.absences') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('admin.requests.absences') ? 'border-b-2 border-indigo-400 text-gray-900' : 'border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                {{ __('Absences') }}
                            </a>
                        @elseif(Auth::user()->hasRole('teacher'))
                            <a href="{{ route('teacher.dashboard') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('teacher.dashboard') ? 'border-b-2 border-indigo-400 text-gray-900' : 'border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                {{ __('Dashboard') }}
                            </a>
                            <a href="{{ route('teacher.modules') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('teacher.modules') ? 'border-b-2 border-indigo-400 text-gray-900' : 'border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                {{ __('Modules') }}
                            </a>
                            <a href="{{ route('teacher.grades.index') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('teacher.grades.*') ? 'border-b-2 border-indigo-400 text-gray-900' : 'border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                {{ __('Grades') }}
                            </a>
                            <a href="{{ route('teacher.attendance.index') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('teacher.attendance.*') ? 'border-b-2 border-indigo-400 text-gray-900' : 'border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                {{ __('Attendance') }}
                            </a>
                            <a href="{{ route('teacher.lesson-logs.index') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('teacher.lesson-logs.*') ? 'border-b-2 border-indigo-400 text-gray-900' : 'border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                {{ __('Lesson Logs') }}
                            </a>
                            <a href="{{ route('teacher.reservations.index') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('teacher.reservations.*') ? 'border-b-2 border-indigo-400 text-gray-900' : 'border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                {{ __('Reservations') }}
                            </a>
                        @elseif(Auth::user()->hasRole('student'))
                            <a href="{{ route('student.dashboard') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('student.dashboard') ? 'border-b-2 border-indigo-400 text-gray-900' : 'border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                {{ __('Dashboard') }}
                            </a>
                            <a href="{{ route('student.grades') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('student.grades') || request()->routeIs('student.grades.index') ? 'border-b-2 border-indigo-400 text-gray-900' : 'border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                {{ __('Grades') }}
                            </a>
                            <a href="{{ route('student.absences') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('student.absences') ? 'border-b-2 border-indigo-400 text-gray-900' : 'border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                {{ __('Absences') }}
                            </a>
                            <a href="{{ route('student.requests') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('student.requests') ? 'border-b-2 border-indigo-400 text-gray-900' : 'border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                {{ __('Requests') }}
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <div class="relative inline-block text-left">
                    <button id="dropdown-button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none">
                        <div>{{ Auth::user()->name }}</div>

                        <div class="ms-1">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>

                    <div id="dropdown-content" class="hidden origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                        <div class="py-1">
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    {{ __('Log Out') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button id="hamburger-button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none">
                    <svg id="hamburger-icon" class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg id="close-icon" class="hidden h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div id="mobile-menu" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @auth
                @if(Auth::user()->hasRole('admin'))
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 border-l-4 border-transparent text-base font-medium {{ request()->routeIs('admin.dashboard') ? 'border-indigo-400 text-indigo-700 bg-indigo-50' : 'text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">
                        {{ __('Dashboard') }}
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="block px-3 py-2 border-l-4 border-transparent text-base font-medium {{ request()->routeIs('admin.users.*') ? 'border-indigo-400 text-indigo-700 bg-indigo-50' : 'text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">
                        {{ __('Users') }}
                    </a>
                    <a href="{{ route('admin.schedules.index') }}" class="block px-3 py-2 border-l-4 border-transparent text-base font-medium {{ request()->routeIs('admin.schedules.*') ? 'border-indigo-400 text-indigo-700 bg-indigo-50' : 'text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">
                        {{ __('Schedules') }}
                    </a>
                    <a href="{{ route('admin.reservations') }}" class="block px-3 py-2 border-l-4 border-transparent text-base font-medium {{ request()->routeIs('admin.reservations') || request()->routeIs('admin.requests.reservations') ? 'border-indigo-400 text-indigo-700 bg-indigo-50' : 'text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">
                        {{ __('Reservations') }}
                    </a>
                    <a href="{{ route('admin.requests.documents') }}" class="block px-3 py-2 border-l-4 border-transparent text-base font-medium {{ request()->routeIs('admin.requests.documents') ? 'border-indigo-400 text-indigo-700 bg-indigo-50' : 'text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">
                        {{ __('Requests') }}
                    </a>
                    <a href="{{ route('admin.requests.absences') }}" class="block px-3 py-2 border-l-4 border-transparent text-base font-medium {{ request()->routeIs('admin.requests.absences') ? 'border-indigo-400 text-indigo-700 bg-indigo-50' : 'text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">
                        {{ __('Absences') }}
                    </a>
                @elseif(Auth::user()->hasRole('teacher'))
                    <a href="{{ route('teacher.dashboard') }}" class="block px-3 py-2 border-l-4 border-transparent text-base font-medium {{ request()->routeIs('teacher.dashboard') ? 'border-indigo-400 text-indigo-700 bg-indigo-50' : 'text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">
                        {{ __('Dashboard') }}
                    </a>
                    <a href="{{ route('teacher.modules') }}" class="block px-3 py-2 border-l-4 border-transparent text-base font-medium {{ request()->routeIs('teacher.modules') ? 'border-indigo-400 text-indigo-700 bg-indigo-50' : 'text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">
                        {{ __('Modules') }}
                    </a>
                    <a href="{{ route('teacher.grades.index') }}" class="block px-3 py-2 border-l-4 border-transparent text-base font-medium {{ request()->routeIs('teacher.grades.*') ? 'border-indigo-400 text-indigo-700 bg-indigo-50' : 'text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">
                        {{ __('Grades') }}
                    </a>
                    <a href="{{ route('teacher.attendance.index') }}" class="block px-3 py-2 border-l-4 border-transparent text-base font-medium {{ request()->routeIs('teacher.attendance.*') ? 'border-indigo-400 text-indigo-700 bg-indigo-50' : 'text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">
                        {{ __('Attendance') }}
                    </a>
                    <a href="{{ route('teacher.lesson-logs.index') }}" class="block px-3 py-2 border-l-4 border-transparent text-base font-medium {{ request()->routeIs('teacher.lesson-logs.*') ? 'border-indigo-400 text-indigo-700 bg-indigo-50' : 'text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">
                        {{ __('Lesson Logs') }}
                    </a>
                    <a href="{{ route('teacher.reservations.index') }}" class="block px-3 py-2 border-l-4 border-transparent text-base font-medium {{ request()->routeIs('teacher.reservations.*') ? 'border-indigo-400 text-indigo-700 bg-indigo-50' : 'text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">
                        {{ __('Reservations') }}
                    </a>
                @elseif(Auth::user()->hasRole('student'))
                    <a href="{{ route('student.dashboard') }}" class="block px-3 py-2 border-l-4 border-transparent text-base font-medium {{ request()->routeIs('student.dashboard') ? 'border-indigo-400 text-indigo-700 bg-indigo-50' : 'text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">
                        {{ __('Dashboard') }}
                    </a>
                    <a href="{{ route('student.grades') }}" class="block px-3 py-2 border-l-4 border-transparent text-base font-medium {{ request()->routeIs('student.grades') || request()->routeIs('student.grades.index') ? 'border-indigo-400 text-indigo-700 bg-indigo-50' : 'text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">
                        {{ __('Grades') }}
                    </a>
                    <a href="{{ route('student.absences') }}" class="block px-3 py-2 border-l-4 border-transparent text-base font-medium {{ request()->routeIs('student.absences') ? 'border-indigo-400 text-indigo-700 bg-indigo-50' : 'text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">
                        {{ __('Absences') }}
                    </a>
                    <a href="{{ route('student.requests') }}" class="block px-3 py-2 border-l-4 border-transparent text-base font-medium {{ request()->routeIs('student.requests') ? 'border-indigo-400 text-indigo-700 bg-indigo-50' : 'text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">
                        {{ __('Requests') }}
                    </a>
                @endif
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-3 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

<script>
    // Dropdown toggle
    document.getElementById('dropdown-button')?.addEventListener('click', function() {
        const content = document.getElementById('dropdown-content');
        content.classList.toggle('hidden');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const button = document.getElementById('dropdown-button');
        const content = document.getElementById('dropdown-content');
        if (button && content && !button.contains(event.target) && !content.contains(event.target)) {
            content.classList.add('hidden');
        }
    });

    // Mobile menu toggle
    document.getElementById('hamburger-button')?.addEventListener('click', function() {
        const menu = document.getElementById('mobile-menu');
        const hamburgerIcon = document.getElementById('hamburger-icon');
        const closeIcon = document.getElementById('close-icon');
        menu.classList.toggle('hidden');
        hamburgerIcon.classList.toggle('hidden');
        closeIcon.classList.toggle('hidden');
    });
</script>
