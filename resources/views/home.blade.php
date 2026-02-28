<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>EasyColoc - Gérez vos colocations simplement</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Tailwind -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .feature-card {
            transition: all 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Navigation publique -->
    <nav class="bg-white shadow-lg fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <!-- Logo -->
                    <a href="/" class="flex items-center space-x-2 group">
                        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-2 rounded-lg shadow-md transform group-hover:scale-110 transition-transform duration-200">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                            </svg>
                        </div>
                        <span class="text-gray-800 font-bold text-xl tracking-tight">Easy<span class="text-blue-600">Coloc</span></span>
                    </a>
                </div>

                <!-- Menu desktop -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-gray-600 hover:text-blue-600 transition">Fonctionnalités</a>
                    <a href="#how-it-works" class="text-gray-600 hover:text-blue-600 transition">Comment ça marche</a>
                    <a href="#testimonials" class="text-gray-600 hover:text-blue-600 transition">Témoignages</a>
                    <a href="#pricing" class="text-gray-600 hover:text-blue-600 transition">Tarifs</a>
                </div>

                <!-- Boutons -->
                <div class="flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-2 rounded-lg hover:shadow-lg transition-all duration-200 transform hover:scale-105">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 transition font-medium">Se connecter</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-2 rounded-lg hover:shadow-lg transition-all duration-200 transform hover:scale-105">
                                    S'inscrire
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="gradient-bg min-h-screen flex items-center pt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="text-white">
                    <h1 class="text-5xl md:text-6xl font-bold leading-tight mb-6">
                        Gérez votre colocation <span class="text-yellow-300">simplement</span>
                    </h1>
                    <p class="text-xl text-white/90 mb-8">
                        EasyColoc vous aide à gérer les dépenses, les tâches et la communication entre colocataires. Fini les calculs compliqués !
                    </p>
                    <div class="flex space-x-4">
                        <a href="{{ route('register') }}" class="bg-white text-blue-600 px-8 py-4 rounded-lg font-bold text-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                            Commencer gratuitement
                        </a>
                        <a href="#features" class="border-2 border-white text-white px-8 py-4 rounded-lg font-bold text-lg hover:bg-white hover:text-blue-600 transition-all duration-200">
                            En savoir plus
                        </a>
                    </div>
                    <div class="flex items-center space-x-8 mt-12">
                        <div class="flex -space-x-2">
                            <img src="https://randomuser.me/api/portraits/women/1.jpg" class="w-10 h-10 rounded-full border-2 border-white" alt="User">
                            <img src="https://randomuser.me/api/portraits/men/2.jpg" class="w-10 h-10 rounded-full border-2 border-white" alt="User">
                            <img src="https://randomuser.me/api/portraits/women/3.jpg" class="w-10 h-10 rounded-full border-2 border-white" alt="User">
                        </div>
                        <p class="text-white/90"><span class="font-bold text-white">+2000</span> colocataires nous font confiance</p>
                    </div>
                </div>
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80" 
                         alt="Colocation" 
                         class="rounded-2xl shadow-2xl transform rotate-3 hover:rotate-0 transition-all duration-300">
                    <div class="absolute -bottom-6 -left-6 bg-white p-4 rounded-lg shadow-xl">
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                            <span class="text-sm font-medium">124 colocations actives</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Tout ce dont vous avez besoin</h2>
                <p class="text-xl text-gray-600">Des fonctionnalités conçues pour simplifier la vie en colocation</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="feature-card bg-gray-50 p-8 rounded-2xl">
                    <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Gestion des dépenses</h3>
                    <p class="text-gray-600">Ajoutez vos dépenses, répartissez-les automatiquement et suivez qui doit quoi à qui.</p>
                </div>

                <!-- Feature 2 -->
                <div class="feature-card bg-gray-50 p-8 rounded-2xl">
                    <div class="w-16 h-16 bg-green-100 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Invitations faciles</h3>
                    <p class="text-gray-600">Invitez vos colocataires par email. Ils reçoivent un lien pour rejoindre votre colocation.</p>
                </div>

                <!-- Feature 3 -->
                <div class="feature-card bg-gray-50 p-8 rounded-2xl">
                    <div class="w-16 h-16 bg-purple-100 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Statistiques claires</h3>
                    <p class="text-gray-600">Visualisez vos dépenses par catégorie, par mois et suivez votre réputation.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="gradient-bg py-20">
        <div class="max-w-4xl mx-auto text-center px-4">
            <h2 class="text-4xl font-bold text-white mb-6">Prêt à simplifier votre colocation ?</h2>
            <p class="text-xl text-white/90 mb-8">Rejoignez des milliers de colocataires qui utilisent déjà EasyColoc</p>
            <a href="{{ route('register') }}" class="bg-white text-blue-600 px-8 py-4 rounded-lg font-bold text-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 inline-block">
                Créer mon compte gratuitement
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="bg-white p-2 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                            </svg>
                        </div>
                        <span class="font-bold text-xl">EasyColoc</span>
                    </div>
                    <p class="text-gray-400">Simplifiez la vie en colocation.</p>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Produit</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#features" class="hover:text-white transition">Fonctionnalités</a></li>
                        <li><a href="#pricing" class="hover:text-white transition">Tarifs</a></li>
                        <li><a href="#faq" class="hover:text-white transition">FAQ</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Légal</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition">Confidentialité</a></li>
                        <li><a href="#" class="hover:text-white transition">CGU</a></li>
                        <li><a href="#" class="hover:text-white transition">Mentions légales</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Contact</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li>contact@easycoloc.com</li>
                        <li>01 23 45 67 89</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} EasyColoc. Tous droits réservés.</p>
            </div>
        </div>
    </footer>
</body>
</html>