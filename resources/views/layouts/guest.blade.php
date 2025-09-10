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
        :root {
            --color-background: #F7F7FF;
            --color-primary: #279AF1;
            --color-secondary: #23B5D3;
            --color-dark: #070600;
        }
        
        .bg-primary { background-color: var(--color-primary); }
        .bg-secondary { background-color: var(--color-secondary); }
        .text-primary { color: var(--color-primary); }
        .text-secondary { color: var(--color-secondary); }
        .border-primary { border-color: var(--color-primary); }
        .border-secondary { border-color: var(--color-secondary); }
        
        body { background-color: var(--color-background); }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen flex flex-col justify-center">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-primary">CollaBox</h1>
            <p class="text-gray-600">Project Collaboration Made Easy</p>
        </div>
        
        @yield('content')
    </div>
</body>
</html>
