<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Teaser App</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-gray-50 text-gray-800">
    <!-- Sticky Header -->
    <header class="bg-green-600 text-white sticky top-0 px-6 py-4 relative z-50 shadow-sm">
        <!-- Centered Website title -->
        <h1 class="absolute left-1/2 transform -translate-x-1/2 text-lg md:text-xl font-medium ">Website</h1>

        <!-- Right-aligned content -->
        <div class="flex justify-end items-center space-x-4">
            @auth
                <span class="text-green-100 text-sm">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-white hover:text-green-200 underline transition-colors text-sm">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}"
                    class="text-white hover:text-green-200 underline transition-colors text-sm">Login</a>
                <a href="{{ route('register') }}"
                    class="text-white hover:text-green-200 underline transition-colors text-sm">Register</a>
            @endauth
        </div>
    </header>

    <!-- Main Content -->
    <main class="py-8 min-h-screen">
        @isset($slot)
            {{ $slot }}
        @else
            @yield('content')
        @endisset
    </main>

    @livewireScripts
    @stack('scripts')
</body>

</html>
