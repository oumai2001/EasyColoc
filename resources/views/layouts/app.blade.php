<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

<<<<<<< HEAD
    <title>@yield('title', 'EasyColoc') - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
=======
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
>>>>>>> 8e94925080aafa664147f8b1fd6ee70babb48e2c

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

<<<<<<< HEAD
    <!-- Styles supplémentaires -->
    @stack('styles')
</head>
<body class="font-sans antialiased ">
=======
    <!-- Tailwind colors personnalisées -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary': '#8B4513',       // Saddle Brown
                        'primary-light': '#A0522D', // Sienna
                        'primary-dark': '#5D2E0C',  // Darker Brown
                        'background-light': '#FDFBF7', // Warm off-white
                        'background-dark': '#1C1917'
                    },
                },
            },
        }
    </script>
</head>
<body class="font-sans antialiased bg-background-light dark:bg-background-dark">
>>>>>>> 8e94925080aafa664147f8b1fd6ee70babb48e2c
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        @include('layouts.navigation')

        <!-- Page Heading -->
<<<<<<< HEAD
        @if (isset($header))
        
            <header class=bg-amber-900 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main class="flex-grow">
            {{ $slot }}
        </main>

        <!-- Footer -->
        @include('layouts.footer')
    </div>

    <!-- Scripts supplémentaires -->
    @stack('scripts')
=======
        @isset($header)
            <header class="bg-primary-light shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-white font-bold">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="flex-1 bg-background-light dark:bg-background-dark p-6">
            {{ $slot }}
        </main>

        <!-- Optional Footer / Bottom Nav -->
        <footer class="bg-primary text-white py-4 text-center">
            © {{ date('Y') }} {{ config('app.name', 'Laravel') }}. Tous droits réservés.
        </footer>
    </div>
>>>>>>> 8e94925080aafa664147f8b1fd6ee70babb48e2c
</body>
</html>