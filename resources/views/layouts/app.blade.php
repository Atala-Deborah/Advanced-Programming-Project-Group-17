<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
        body { 
            font-family: 'Inter', sans-serif;
            background: url("{{ asset('bg.jpg') }}") no-repeat center center fixed;
            background-size: cover;
            position: relative;
        }
        body::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(255, 255, 255, 0.9); 
            z-index: -1;
        }

        /* Hero section */
        .hero {
            position: relative;
            background: url("{{ asset('bg.jpg') }}") no-repeat center center/cover;
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }
        .hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.84);
        }
        .hero-content {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .hero img {
            max-height: 80px;
            margin-bottom: 0.5rem;
        }

        /* Sidebar navigation styles */
        .nav-link {
            position: relative;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(147, 197, 253, 0.1));
            transform: translateX(4px);
        }
        
        .nav-link.active {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
            transform: translateX(6px);
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }
        
        .nav-link.active svg {
            color: white;
        }
        
        .nav-link:not(.active) svg {
            color: #2563eb;
        }
        

    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen relative flex flex-col">
        
        <!-- Hero Section -->
        <section class="hero flex-shrink-0">
            <div class="hero-content">
                <img src="{{ asset('logowhite.png') }}" alt="CollaBox Logo">
                <h1 class="text-2xl md:text-3xl font-bold">Facility Management System</h1>
            </div>
        </section>

        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg">
            <div class="flex flex-col h-full">

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
                        <span class="text-sm font-semibold text-gray-900">Group 17</span>
                        <span class="text-xs text-gray-500">group17@gmail.com</span>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
                    <a href="{{ route('dashboard') }}" 
                       class="nav-link flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('projects.index') }}" 
                       class="nav-link flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 {{ request()->routeIs('projects.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <span>Projects</span>
                    </a>

                    <a href="{{ route('facilities.index') }}" 
                       class="nav-link flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 {{ request()->routeIs('facilities.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <span>Facilities</span>
                    </a>

                    <a href="{{ route('equipment.index') }}" 
                       class="nav-link flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 {{ request()->routeIs('equipment.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a2 2 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"/>
                        </svg>
                        <span>Equipment</span>
                    </a>

                    <a href="{{ route('services.index') }}" 
                       class="nav-link flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 {{ request()->routeIs('services.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span>Services</span>
                    </a>

                    <a href="{{ route('programs.index') }}" 
                       class="nav-link flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 {{ request()->routeIs('programs.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <span>Programs</span>
                    </a>

                    <a href="{{ route('participants.index') }}" 
                       class="nav-link flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 {{ request()->routeIs('participants.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <span>Participants</span>
                    </a>

                    <a href="{{ route('outcomes.index') }}" 
                       class="nav-link flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 {{ request()->routeIs('outcomes.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span>Outcomes</span>
                    </a>
                </nav>

                <!-- Logout -->
                <div class="border-t border-gray-200 px-3 py-3">
                    <button class="nav-link flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 w-full hover:bg-red-50 hover:text-red-700 transition-all duration-200">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1"/>
                        </svg>
                        <span class="text-sm font-medium">Logout</span>
                    </button>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="lg:pl-64 relative z-10 flex flex-col flex-1">
            <main class="flex-1 py-6">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    @yield('content')
                </div>
            </main>
            
            <!-- Footer -->
            <footer class="bg-gray-50 border-t border-gray-200 py-6 mt-auto">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="text-center text-sm text-gray-500">
                        <p>&copy; {{ date('Y') }} Advanced Programming Capstone Project. All rights reserved.</p>
                        <p class="mt-1">Innovation Hub Management System - Group 17</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Include Delete Modal Component -->
    @include('components.delete-modal')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add smooth animations on page load
            const sidebar = document.querySelector('aside');
            if (sidebar) {
                sidebar.style.transform = 'translateX(-100%)';
                sidebar.style.transition = 'transform 0.3s ease';
                
                setTimeout(() => {
                    sidebar.style.transform = 'translateX(0)';
                }, 100);
            }
            
            // Add hover effects for better UX
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.addEventListener('mouseenter', function() {
                    if (!this.classList.contains('active')) {
                        this.style.transform = 'translateX(4px)';
                    }
                });
                
                link.addEventListener('mouseleave', function() {
                    if (!this.classList.contains('active')) {
                        this.style.transform = 'translateX(0)';
                    }
                });
            });
        });
    </script>
</body>
</html>
