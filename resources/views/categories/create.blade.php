<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Nouvelle catégorie - {{ $colocation->name }}
            </h2>
            <a href="{{ route('colocations.show', $colocation) }}" class="text-gray-600 hover:text-gray-800">
                ← Retour
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="p-6">
                    <form action="{{ route('categories.store', $colocation) }}" method="POST">
                        @csrf

                        <div class="mb-6">
                            <label class="block text-gray-700 font-medium mb-2">Nom de la catégorie</label>
                            <input type="text" 
                                   name="name" 
                                   value="{{ old('name') }}"
                                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                                   placeholder="Ex: Courses, Sorties, Épargne..."
                                   required>
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 font-medium mb-2">Couleur</label>
                            <div class="flex items-center space-x-4">
                                <input type="color" 
                                       name="color" 
                                       value="{{ old('color', '#78350f') }}"
                                       class="w-16 h-10 rounded border">
                                <span class="text-sm text-gray-500">Choisissez une couleur pour la catégorie</span>
                            </div>
                            @error('color')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('colocations.show', $colocation) }}" 
                               class="px-6 py-2 border rounded-lg hover:bg-gray-50 transition">
                                Annuler
                            </a>
                            <button type="submit" 
                                    class="px-6 py-2 bg-gradient-to-r from-amber-600 to-amber-700 text-white rounded-lg hover:shadow-lg transition">
                                Créer la catégorie
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Exemples de catégories -->
            <div class="bg-amber-50 rounded-xl p-6 mt-6">
                <h4 class="font-medium text-amber-800 mb-3">Catégories populaires :</h4>
                <div class="flex flex-wrap gap-2">
                    <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-sm">Loyer</span>
                    <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-sm">Électricité</span>
                    <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-sm">Courses</span>
                    <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-sm">Internet</span>
                    <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-sm">Sorties</span>
                    <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-sm">Épargne</span>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>