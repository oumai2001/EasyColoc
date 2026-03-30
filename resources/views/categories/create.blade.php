<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center bg-gradient-to-r from-amber-800 to-amber-700 p-4 rounded-t-lg">
            <h2 class="font-semibold text-xl text-black leading-tight">
                Nouvelle catégorie - {{ $colocation->name }}
            </h2>
            <a href="{{ route('colocations.show', $colocation) }}" class="text-amber-200 hover:text-white transition">
                ← Retour
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-amber-50">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <!-- Formulaire principal -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-amber-200">
                <div class="bg-gradient-to-r from-amber-800 to-amber-700 px-6 py-4">
                    <h3 class="text-lg font-medium text-black">Créer une nouvelle catégorie</h3>
                </div>
                
                <div class="p-6">
                    @if($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <strong>Veuillez corriger les erreurs :</strong>
                            <ul class="mt-2">
                                @foreach($errors->all() as $error)
                                    <li>- {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('categories.store', $colocation) }}" method="POST">
                        @csrf

                        <div class="mb-6">
                            <label class="block text-black font-medium mb-2">
                                Nom de la catégorie <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="name" 
                                   value="{{ old('name') }}"
                                   class="w-full px-4 py-3 border-2 border-amber-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-black placeholder-gray-400"
                                   placeholder="Ex: Courses, Sorties, Épargne..."
                                   required>
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label class="block text-black font-medium mb-2">
                                Couleur <span class="text-red-500">*</span>
                            </label>
                            <div class="flex items-center space-x-4">
                                <div class="relative">
                                    <input type="color" 
                                           name="color" 
                                           value="{{ old('color', '#000000') }}"
                                           class="w-16 h-12 rounded-lg border-2 border-amber-200 cursor-pointer"
                                           id="colorPicker">
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-8 h-8 rounded-full" style="background-color: {{ old('color', '#000000') }}" id="colorPreview"></div>
                                        <span class="text-sm text-black" id="colorValue">{{ old('color', '#000000') }}</span>
                                    </div>
                                    <p class="text-xs text-gray-600 mt-1">Cliquez sur le cercle pour choisir une couleur</p>
                                </div>
                            </div>
                            @error('color')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-amber-100">
                            <a href="{{ route('colocations.show', $colocation) }}" 
                               class="px-6 py-2.5 border-2 border-amber-200 rounded-lg hover:bg-amber-50 transition text-black font-medium">
                                Annuler
                            </a>
                            <button type="submit" 
                                    class="px-6 py-2.5 bg-gradient-to-r from-amber-600 to-amber-700 text-black font-medium rounded-lg hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                                Créer la catégorie
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Exemples de catégories -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-amber-200 mt-6">
                <div class="bg-gradient-to-r from-amber-800 to-amber-700 px-6 py-4">
                    <h4 class="font-medium text-black">Catégories populaires</h4>
                </div>
                <div class="p-6">
                    <p class="text-black mb-4">Vous pouvez vous inspirer de ces catégories existantes :</p>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        <div class="flex items-center space-x-2 p-3 bg-amber-50 rounded-lg border border-amber-200">
                            <div class="w-4 h-4 rounded-full" style="background-color: #78350f"></div>
                            <span class="text-black">Loyer</span>
                        </div>
                        <div class="flex items-center space-x-2 p-3 bg-amber-50 rounded-lg border border-amber-200">
                            <div class="w-4 h-4 rounded-full" style="background-color: #b45309"></div>
                            <span class="text-black">Électricité</span>
                        </div>
                        <div class="flex items-center space-x-2 p-3 bg-amber-50 rounded-lg border border-amber-200">
                            <div class="w-4 h-4 rounded-full" style="background-color: #0f766e"></div>
                            <span class="text-black">Eau</span>
                        </div>
                        <div class="flex items-center space-x-2 p-3 bg-amber-50 rounded-lg border border-amber-200">
                            <div class="w-4 h-4 rounded-full" style="background-color: #1e40af"></div>
                            <span class="text-black">Internet</span>
                        </div>
                        <div class="flex items-center space-x-2 p-3 bg-amber-50 rounded-lg border border-amber-200">
                            <div class="w-4 h-4 rounded-full" style="background-color: #166534"></div>
                            <span class="text-black">Courses</span>
                        </div>
                        <div class="flex items-center space-x-2 p-3 bg-amber-50 rounded-lg border border-amber-200">
                            <div class="w-4 h-4 rounded-full" style="background-color: #86198f"></div>
                            <span class="text-black">Sorties</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Astuce -->
            <div class="bg-amber-100 rounded-xl p-4 mt-6 border border-amber-300">
                <div class="flex items-start space-x-3">
                    <svg class="w-6 h-6 text-amber-800 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h5 class="font-medium text-black">💡 Astuce :</h5>
                        <p class="text-black">
                            Les catégories vous aident à organiser vos dépenses. 
                            Vous pourrez ensuite voir des statistiques par catégorie et filtrer vos dépenses.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const colorPicker = document.getElementById('colorPicker');
            const colorPreview = document.getElementById('colorPreview');
            const colorValue = document.getElementById('colorValue');
            
            if (colorPicker && colorPreview && colorValue) {
                colorPicker.addEventListener('input', function(e) {
                    const color = e.target.value;
                    colorPreview.style.backgroundColor = color;
                    colorValue.textContent = color;
                    colorValue.style.color = color;
                });
            }
        });
    </script>
</x-app-layout>