<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier la colocation') }} : {{ $colocation->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('colocations.update', $colocation) }}">
                        @csrf
                        @method('PATCH')

                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">
                                Nom de la colocation
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name', $colocation->name) }}" 
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror"
                                   required
                                   placeholder="Ex: Coloc des artistes">
                            @error('name')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Infos supplémentaires (optionnel) -->
                        <div class="mb-4 p-4 bg-gray-50 rounded">
                            <p class="text-sm text-gray-600 mb-2">
                                <span class="font-medium">Créée le :</span> {{ $colocation->created_at->format('d/m/Y') }}
                            </p>
                            <p class="text-sm text-gray-600">
                                <span class="font-medium">Propriétaire :</span> {{ $colocation->owner->name }}
                            </p>
                            @if($colocation->status == 'cancelled')
                                <p class="text-sm text-red-600 mt-2">
                                    ⚠️ Cette colocation est annulée
                                </p>
                            @endif
                        </div>

                        <div class="flex items-center justify-between">
                            <a href="{{ route('colocations.show', $colocation) }}" 
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Annuler
                            </a>
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Mettre à jour
                            </button>
                        </div>
                    </form>

                    <!-- Section danger (pour l'owner) -->
                    @if($colocation->isOwner(Auth::user()) && $colocation->status == 'active')
                        <div class="mt-8 pt-6 border-t border-red-200">
                            <h3 class="text-lg font-medium text-red-600 mb-4">Zone dangereuse</h3>
                            
                            <div class="bg-red-50 border border-red-200 rounded p-4">
                                <p class="text-sm text-red-700 mb-4">
                                    <strong>⚠️ Attention :</strong> L'annulation d'une colocation est irréversible. 
                                    Tous les membres seront notifiés et les soldes seront gelés.
                                </p>
                                
                                <form action="{{ route('colocations.cancel', $colocation) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Êtes-vous ABSOLUMENT sûr de vouloir annuler cette colocation ?\n\nCette action est irréversible et affectera tous les membres.')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="bg-red-600 hover:bg-red-800 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                        Annuler définitivement la colocation
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>