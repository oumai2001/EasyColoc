<x-app-layout>
    <x-slot name="header">
<<<<<<< HEAD
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tableau de bord') }}
            </h2>
            <div class="flex space-x-2">
                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm">
                    {{ Auth::user()->reputation }} points de réputation
                </span>
            </div>
        </div>
=======
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
>>>>>>> 8e94925080aafa664147f8b1fd6ee70babb48e2c
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
<<<<<<< HEAD
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Colocations actives -->
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-[#000000]">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[#000000] text-sm">Colocations actives</p>
                            <p class="text-3xl font-bold">{{ Auth::user()->activeColocations->count() }}</p>
                        </div>
                        <div class="bg-white/20 p-3 rounded-xl">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total dépensé -->
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg p-6 text-[#000000]">
                    @php
                        $totalSpent = 0;
                        foreach(Auth::user()->activeColocations as $coloc) {
                            $totalSpent += $coloc->expenses()->where('user_id', Auth::id())->sum('amount');
                        }
                    @endphp
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm">Total dépensé</p>
                            <p class="text-3xl font-bold">{{ number_format($totalSpent, 0) }} €</p>
                        </div>
                        <div class="bg-white/20 p-3 rounded-xl">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Réputation -->
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-lg p-6text-[#000000]">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-100 text-sm">Niveau de confiance</p>
                            <p class="text-3xl font-bold">
                                @if(Auth::user()->reputation >= 10)
                                    ★ Gold
                                @elseif(Auth::user()->reputation >= 5)
                                    ★ Silver
                                @elseif(Auth::user()->reputation >= 0)
                                    ★ Bronze
                                @else
                                    ⚠️ Risqué
                                @endif
                            </p>
                        </div>
                        <div class="bg-white/20 p-3 rounded-xl">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-1 gap-6 mb-6">
                <!-- Créer une colocation -->
                @if(Auth::user()->activeColocations->count() == 0)
                    <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
                        <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Créer votre première colocation</h3>
                        <p class="text-gray-600 mb-6">Commencez par créer une colocation et invitez vos colocataires</p>
                        <a href="{{ route('colocations.create') }}" 
                           class="inline-block bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-3 rounded-lg font-medium hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                            Créer une colocation
                        </a>
                    </div>
                @endif

                <!-- Activité récente -->
                <div class="bg-white rounded-2xl shadow-lg p-2 ">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Activité récente</h3>
                    @php
                        $recentExpenses = \App\Models\Expense::whereIn('colocation_id', Auth::user()->activeColocations->pluck('id'))
                            ->with(['payer', 'colocation'])
                            ->latest()
                            ->take(5)
                            ->get();
                    @endphp

                    @if($recentExpenses->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentExpenses as $expense)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $expense->title }}</p>
                                        <p class="text-sm text-gray-600">
                                            {{ $expense->colocation->name }} • {{ $expense->expense_date->format('d/m/Y') }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-blue-600">{{ number_format($expense->amount, 2) }} €</p>
                                        <p class="text-xs text-gray-500">par {{ $expense->payer->name }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4 text-center">
                            <a href="{{ route('colocations.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                Voir toutes mes colocations →
                            </a>
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">Aucune activité récente</p>
                    @endif
                </div>
            </div>

            <!-- Mes colocations -->
            @if(Auth::user()->activeColocations->count() > 0)
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Mes colocations</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach(Auth::user()->activeColocations as $colocation)
                            <div class="border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition-all duration-200">
                                <div class="h-2 bg-gradient-to-r from-blue-500 to-indigo-500"></div>
                                <div class="p-6">
                                    <h4 class="text-lg font-bold text-gray-900 mb-2">{{ $colocation->name }}</h4>
                                    <p class="text-sm text-gray-600 mb-4">{{ $colocation->activeUsers->count() }} membres</p>
                                    
                                    @php
                                        $userBalance = \App\Http\Controllers\ExpenseController::calculateBalances($colocation)[Auth::id()] ?? null;
                                    @endphp
                                    
                                    @if($userBalance)
                                        <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                                            <p class="text-sm text-gray-600">Votre solde</p>
                                            <p class="text-lg font-bold {{ $userBalance['balance'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                                {{ number_format($userBalance['balance'], 2) }} €
                                            </p>
                                        </div>
                                    @endif
                                    
                                    <a href="{{ route('colocations.show', $colocation) }}" 
                                       class="block text-center bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 px-4 rounded-lg transition">
                                        Voir les détails
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
=======
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
>>>>>>> 8e94925080aafa664147f8b1fd6ee70babb48e2c
