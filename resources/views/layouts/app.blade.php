<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-sans antialiased bg-blue-50">
<div class="flex h-screen" x-data="{ sidebarOpen: false }">

    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
           class="fixed z-30 inset-y-0 left-0 w-64 bg-blue-100 text-blue-900 border-r border-blue-300 transform transition-transform duration-300 ease-in-out md:relative md:translate-x-0 md:flex-shrink-0">

        <div class="h-16 flex items-center justify-center text-2xl font-bold border-b border-blue-300">
            <span>GesClient Netsys</span>
        </div>

        <nav class="mt-6">
            <ul class="space-y-6 px-4">
                <li>
                    <a href="" class="flex items-center space-x-3 p-3 rounded hover:bg-blue-200 hover:text-blue-900 transition">
                        <i class="fas fa-house text-blue-600 w-5"></i>
                        <span>Tableau de bord</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('client.index') }}" class="flex items-center space-x-3 p-3 rounded hover:bg-blue-200 hover:text-blue-900 transition">
                        <i class="fas fa-box-open text-blue-600 w-5"></i>
                        <span>Gestion Client</span>
                    </a>
                </li>
                <li>
                    <a href="" class="flex items-center space-x-3 p-3 rounded hover:bg-blue-200 hover:text-blue-900 transition">
                        <i class="fas fa-chart-line text-blue-600 w-5"></i>
                        <span>Rapport Statistique</span>
                    </a>
                </li>
                <li>
                    <a href="" class="flex items-center space-x-3 p-3 rounded hover:bg-blue-200 hover:text-blue-900 transition">
                        <i class="fas fa-users text-blue-600 w-5"></i>
                        <span>Gestion Installation</span>
                    </a>
                </li>
                <li>
                    <a href="" class="flex items-center space-x-3 p-3 rounded hover:bg-blue-200 hover:text-blue-900 transition">
                        <i class="fas fa-users text-blue-600 w-5"></i>
                        <span>Gestion Users</span>
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- Overlay mobile -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false"
         class="fixed inset-0 z-20 bg-black bg-opacity-50 md:hidden" x-cloak></div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">

        <!-- Top navbar (mobile) -->
        <header class="flex items-center justify-between bg-blue-100 shadow px-4 py-3 md:hidden">
            <button @click="sidebarOpen = true" class="text-blue-700 hover:text-blue-900 focus:outline-none">
                <i class="fas fa-bars fa-lg"></i>
            </button>
            <h1 class="text-lg font-semibold text-blue-900">Netsys Sales</h1>
        </header>

        @include('layouts.navigation')

        @isset($header)
            <header class="bg-blue-100 shadow hidden md:block">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main class="flex-1 overflow-y-auto p-6 bg-blue-50">
            {{ $slot }}
        </main>
    </div>
</div>
</body>
</html>
