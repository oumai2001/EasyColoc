<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Mes Colocations') }}
            </h2>
            @if($activeColocations->count() == 0)
                <a href="{{ route('colocations.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Créer une colocation
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Colocations actives -->
            @if($activeColocations->count() > 0)
                <h3 class="text-lg font-medium mb-4">Colocations actives</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
                    @foreach($activeColocations as $colocation)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h4 class="text-xl font-bold mb-2">{{ $colocation->name }}</h4>
                                <p class="text-gray-600 mb-4">
                                    Propriétaire : {{ $colocation->owner->name }}<br>
                                    Membres : {{ $colocation->activeUsers->count() }}<br>
                                    Statut : 
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded">
                                        {{ $colocation->status }}
                                    </span>
                                </p>

<div class="flex flex-wrap gap-2 mt-4">
    <!-- Voir -->
    <a href="{{ route('colocations.show', $colocation) }}" 
       class="inline-flex items-center bg-blue-500 hover:bg-blue-700 text-white px-3 py-1.5 rounded text-sm transition">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
        </svg>
        Voir
    </a>
    
    <!-- Modifier (seulement pour owner) -->
    @if($colocation->isOwner(Auth::user()))
        <a href="{{ route('colocations.edit', $colocation) }}" 
           class="inline-flex items-center bg-yellow-500 hover:bg-yellow-700 text-white px-3 py-1.5 rounded text-sm transition">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            Modifier
        </a>
    @endif
    
    <!-- Annuler (pour owner) -->
    @if($colocation->isOwner(Auth::user()))
    <a href="{{ route('colocations.confirm-cancel', $colocation) }}" 
       class="inline-flex items-center bg-red-500 hover:bg-red-700 text-white px-3 py-1.5 rounded text-sm transition">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
        </svg>
        Annuler
    </a>
    @else
        <!-- Quitter (pour membre) -->
        <form action="{{ route('colocations.leave', $colocation) }}" method="POST" class="inline">
            @csrf
            <button type="submit" 
                    class="inline-flex items-center bg-orange-500 hover:bg-orange-700 text-white px-3 py-1.5 rounded text-sm transition"
                    onclick="return confirm('Êtes-vous sûr de vouloir quitter cette colocation ?')">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                Quitter
            </button>
        </form>
    @endif
</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                    <div class="p-6 text-center">
                        <p class="text-gray-600 mb-4">Vous n'avez pas encore de colocation active.</p>
                        <a href="{{ route('colocations.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Créer ma première colocation
                        </a>
                    </div>
                </div>
            @endif

            <!-- Historique -->
            @if($historyColocations->count() > 0)
                <h3 class="text-lg font-medium mb-4">Historique</h3>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <table class="min-w-full">
                            <thead>
                                <tr>
                                    <th class="text-left">Nom</th>
                                    <th class="text-left">Rôle</th>
                                    <th class="text-left">Arrivée</th>
                                    <th class="text-left">Départ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($historyColocations as $colocation)
                                    <tr>
                                        <td>{{ $colocation->name }}</td>
                                        <td>{{ $colocation->pivot->role }}</td>
                                        <td>{{ $colocation->pivot->joined_at->format('d/m/Y') }}</td>
                                        <td>{{ $colocation->pivot->left_at->format('d/m/Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>