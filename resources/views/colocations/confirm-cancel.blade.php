<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Confirmer l\'annulation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <!-- Carte de confirmation -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <!-- En-tête avec avertissement -->
                <div class="bg-red-600 px-6 py-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-white">Action irréversible</h3>
                            <p class="text-red-100 text-sm">Vous êtes sur le point d'annuler définitivement cette colocation</p>
                        </div>
                    </div>
                </div>

                <!-- Corps de la page -->
                <div class="px-6 py-8">
                    <!-- Résumé de la colocation -->
                    <div class="mb-8">
                        <h4 class="text-lg font-medium text-gray-900 mb-4">{{ $colocation->name }}</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                            <div class="bg-gray-50 rounded-lg p-4 text-center">
                                <p class="text-3xl font-bold text-gray-800">{{ $membersCount }}</p>
                                <p class="text-sm text-gray-600">Membres</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4 text-center">
                                <p class="text-3xl font-bold text-gray-800">{{ $expensesCount }}</p>
                                <p class="text-sm text-gray-600">Dépenses</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4 text-center">
                                <p class="text-3xl font-bold text-gray-800">{{ number_format($totalSpent, 0) }} €</p>
                                <p class="text-sm text-gray-600">Total dépensé</p>
                            </div>
                        </div>
                    </div>

                    <!-- Avertissements -->
                    <div class="space-y-4 mb-8">
                        @if($hasPendingDebts)
                            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-yellow-700">
                                            <strong>Attention :</strong> Des dettes sont encore en attente. 
                                            En annulant, les dettes des membres seront transférées à votre compte.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="bg-red-50 border-l-4 border-red-400 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-red-700">
                                        <strong>Cette action est irréversible :</strong>
                                    </p>
                                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                        <li>Tous les membres seront retirés automatiquement</li>
                                        <li>Les dépenses seront conservées mais la colocation deviendra inactive</li>
                                        <li>Vous ne pourrez plus ajouter de dépenses</li>
                                        <li>Les invitations en attente seront annulées</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end space-x-4 border-t pt-6">
                        <a href="{{ route('colocations.show', $colocation) }}" 
                           class="px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition">
                            Non, retour à la colocation
                        </a>
                        
                        <form action="{{ route('colocations.cancel', $colocation) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition"
                                    id="confirmCancelBtn">
                                Oui, annuler définitivement
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Carte des membres (optionnel) -->
            @if($membersCount > 0)
                <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-6 py-4">
                        <h4 class="font-medium text-gray-700 mb-3">Membres actuels</h4>
                        <div class="space-y-2">
                            @foreach($colocation->activeUsers as $member)
                                <div class="flex items-center justify-between py-2 border-b last:border-0">
                                    <div class="flex items-center">
                                        @if($member->avatar)
                                            <img src="{{ Storage::url($member->avatar) }}" class="w-8 h-8 rounded-full mr-3">
                                        @else
                                            <div class="w-8 h-8 rounded-full bg-gray-300 mr-3 flex items-center justify-center">
                                                <span class="text-sm font-medium text-gray-600">{{ substr($member->name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="font-medium">{{ $member->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $member->pivot->role }}</p>
                                        </div>
                                    </div>
                                    @if($member->hasDebtsInColocation($colocation))
                                        <span class="text-xs px-2 py-1 bg-yellow-100 text-yellow-800 rounded">
                                            A des dettes
                                        </span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
        // Empêcher les doubles clics
        document.getElementById('confirmCancelBtn')?.addEventListener('click', function(e) {
            this.disabled = true;
            this.innerHTML = 'Annulation en cours...';
        });
    </script>
    @endpush
</x-app-layout>