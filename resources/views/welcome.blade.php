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
            background: linear-gradient(135deg, #78350f 0%, #b45309 100%);
        }
        .feature-card {
            transition: all 0.3s ease;
            border: 1px solid #fef3c7;
        }
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(120, 53, 15, 0.15);
            border-color: #78350f;
        }
        .btn-primary {
            background: linear-gradient(135deg, #78350f 0%, #b45309 100%);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(120, 53, 15, 0.3);
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Navigation publique -->
     <nav class="bg-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                        <div class="flex items-center gap-2 mb-3">
                    <div class="text-[#78350f] p-2 rounded-xl shadow-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                        </svg>
                    </div>

                    <span class="font-bold text-xl text-[#78350f]">
                        EasyColoc
                    </span>
                </div>

                    <div class="flex items-center space-x-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="bg-gradient-to-r from-[#78350f] text-[#000000] px-4 py-2 rounded-lg hover:shadow-lg transition">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="text-gray-600 hover:text-[#78350f]  from-[#78350f]  transition">Connexion</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="bg-gradient-to-r hover:text-[#78350f] from-[#78350f] text-[#000000] px-4 py-2 rounded-lg hover:shadow-lg transition">
                                        Inscription
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

     <!-- Hero Section avec dégradé marron -->
    <section class="gradient-bg min-h-screen flex items-center pt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="text-center max-w-3xl mx-auto">
                <h1 class="text-5xl md:text-6xl font-bold text-white mb-6 leading-tight">
                    Gérez votre colocation en toute <span class="text-amber-200">simplicité</span>
                </h1>
                <p class="text-xl text-amber-100 mb-10">
                    EasyColoc vous aide à gérer les dépenses, suivre les remboursements et maintenir une bonne entente entre colocataires.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('register') }}" class="bg-white text-amber-800 px-8 py-4 rounded-xl font-bold text-lg shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-200">
                        Commencer gratuitement
                    </a>
                    <a href="#features" class="border-2 border-white text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-white hover:text-amber-800 transition-all duration-200">
                        En savoir plus
                    </a>
                </div>
                
                <!-- Stats simples -->
                <div class="flex justify-center items-center space-x-8 mt-16">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-white">500+</div>
                        <div class="text-amber-200">Colocations</div>
                    </div>
                    <div class="w-px h-12 bg-amber-300/30"></div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-white">2000+</div>
                        <div class="text-amber-200">Utilisateurs</div>
                    </div>
                    <div class="w-px h-12 bg-amber-300/30"></div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-white">4.8★</div>
                        <div class="text-amber-200">Note moyenne</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features simples -->
    <section id="features" class="py-20 bg-amber-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-amber-900 mb-4">Comment ça marche ?</h2>
                <p class="text-xl text-amber-700">3 étapes simples pour gérer votre colocation</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="feature-card bg-white p-8 rounded-2xl text-center">
                    <div class="w-16 h-16 bg-amber-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <span class="text-2xl font-bold text-amber-800">1</span>
                    </div>
                    <h3 class="text-xl font-bold text-amber-900 mb-3">Créez votre colocation</h3>
                    <p class="text-amber-700">Invitez vos colocataires par email. Ils rejoignent en un clic.</p>
                </div>

                <!-- Feature 2 -->
                <div class="feature-card bg-white p-8 rounded-2xl text-center">
                    <div class="w-16 h-16 bg-amber-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <span class="text-2xl font-bold text-amber-800">2</span>
                    </div>
                    <h3 class="text-xl font-bold text-amber-900 mb-3">Ajoutez vos dépenses</h3>
                    <p class="text-amber-700">Loyer, courses, factures... La répartition se fait automatiquement.</p>
                </div>

                <!-- Feature 3 -->
                <div class="feature-card bg-white p-8 rounded-2xl text-center">
                    <div class="w-16 h-16 bg-amber-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <span class="text-2xl font-bold text-amber-800">3</span>
                    </div>
                    <h3 class="text-xl font-bold text-amber-900 mb-3">Suivez les remboursements</h3>
                    <p class="text-amber-700">Visualisez qui doit quoi et marquez les paiements effectués.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA simple -->
    <section class="gradient-bg py-16">
        <div class="max-w-4xl mx-auto text-center px-4">
            <h2 class="text-3xl font-bold text-white mb-4">Prêt à simplifier votre colocation ?</h2>
            <p class="text-xl text-amber-100 mb-8">Rejoignez des milliers de colocataires satisfaits</p>
            <a href="{{ route('register') }}" class="bg-white text-amber-800 px-8 py-4 rounded-xl font-bold text-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 inline-block">
                Créer mon compte
            </a>
        </div>
    </section>
<!-- Footer -->
        @include('layouts.footer')
</body>
</html>