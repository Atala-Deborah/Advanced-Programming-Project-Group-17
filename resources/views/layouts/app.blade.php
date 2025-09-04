<!DOCTYPE html>
<html lang="{        .nav-link {
            @apply flex items-center px-4 py-2.5 text-sm text-gray-600 rounded-lg transition-all duration-150 hover:bg-blue-50 hover:text-blue-600 group;
        }

        .nav-link:hover .nav-icon {
            @apply text-blue-600;
        }

        .nav-link.active {
            @apply bg-blue-50 text-blue-700 font-medium;
        }

        .nav-link.active .nav-icon {
            @apply text-blue-600;
        }

        .nav-icon {
            @apply w-5 h-5 mr-3 flex-shrink-0 text-gray-400 transition-colors duration-150;
        }_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CollaBox') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Styles -->
    <style>
        :root {
            --color-background: #F7F7FF;
            --color-primary: #279AF1;
            --color-secondary: #23B5D3;
            --color-dark: #070600;
        }
        
        body { 
            background-color: var(--color-background);
            font-family: 'Inter', sans-serif;
        }

        .nav-link {
            @apply flex items-center px-4 py-2.5 text-sm text-gray-600 rounded-lg transition-all duration-150 hover:bg-blue-50;
        }

        .nav-link:hover {
            @apply text-blue-600;
        }

        .nav-link:hover .nav-icon {
            @apply text-blue-500;
        }

        .nav-link.active {
            @apply bg-blue-50 text-blue-700 font-medium;
        }

        .nav-link.active .nav-icon {
            @apply text-blue-500;
        }

        .nav-icon {
            @apply w-4 h-4 mr-3 flex-shrink-0 text-gray-400 transition-colors duration-150 stroke-[1.5];
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen">
        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg transform transition-transform duration-200 ease-in-out" 
               x-data="{ open: true }" 
               :class="{'translate-x-0': open, '-translate-x-full': !open}">
            <div class="flex flex-col h-full">
                <!-- Logo -->
                <div class="flex items-center h-16 px-6 bg-blue-600">
                    <div class="flex items-center">
                        <span class="text-xl font-bold text-white">CollaBox</span>
                    </div>
                </div>

                <!-- User Profile -->
                <div class="px-6 py-6 border-b border-gray-200">
                    <div class="flex flex-col items-center text-center">
                        <div class="flex-shrink-0 mb-3">
                            <div class="p-2 rounded-full bg-blue-50">
                                <svg class="h-10 w-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm font-semibold text-gray-900">Guest User</span>
                            <span class="text-xs text-gray-500">guest@collabox.com</span>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
                    <a href="{{ route('dashboard') }}" 
                    class="flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-200 nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('projects.index') }}" 
                    class="flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-200 nav-link {{ request()->routeIs('projects.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <span>Projects</span>
                    </a>

                    <a href="{{ route('facilities.index') }}" 
                    class="flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-200 nav-link {{ request()->routeIs('facilities.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <span>Facilities</span>
                    </a>

                    <a href="{{ route('equipment.index') }}" 
                    class="flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-200 nav-link {{ request()->routeIs('equipment.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"/>
                        </svg>
                        <span>Equipment</span>
                    </a>

                    <a href="{{ route('services.index') }}" 
                    class="flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-200 nav-link {{ request()->routeIs('services.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span>Services</span>
                    </a>
                </nav>

<!-- Logout -->
<div class="border-t border-gray-200">
    <button class="flex items-center w-full px-4 py-3 text-gray-700 hover:bg-gray-200">
        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1"/>
        </svg>
        <span class="ml-3 text-sm font-medium">Logout</span>
    </button>
</div>

            </div>
        </aside>

        <!-- Main Content -->
        <div class="lg:pl-64">
            <!-- Top Navigation -->
            <nav class="bg-white shadow-sm">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <button class="lg:hidden px-4 text-gray-500 focus:outline-none focus:text-gray-600" 
                                    x-data @click="$dispatch('toggle-sidebar')">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M4 6h16M4 12h16M4 18h16"/>
                                </svg>
                            </button>
                        </div>
                        <div class="flex items-center">
                            <span class="text-gray-500 text-sm">Welcome to CollaBox</span>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main class="py-6">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>
</html>
