<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Ajouter une dépense - ') }} {{ $colocation->name }}
            </h2>
            <a href="{{ route('colocations.show', $colocation) }}" class="text-blue-500 hover:text-blue-700">
                ← Retour
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
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

                    <form method="POST" action="{{ route('expenses.store', $colocation) }}" id="expenseForm">
                        @csrf

                        <!-- Informations de base -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Titre *</label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}" 
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('title') border-red-500 @enderror"
                                       required>
                                @error('title')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="amount" class="block text-gray-700 text-sm font-bold mb-2">Montant (€) *</label>
                                <input type="number" step="0.01" name="amount" id="amount" value="{{ old('amount') }}"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('amount') border-red-500 @enderror"
                                       required>
                                @error('amount')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="category_id" class="block text-gray-700 text-sm font-bold mb-2">Catégorie *</label>
                                <select name="category_id" id="category_id" 
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('category_id') border-red-500 @enderror"
                                        required>
                                    <option value="">Sélectionnez une catégorie</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="expense_date" class="block text-gray-700 text-sm font-bold mb-2">Date *</label>
                                <input type="date" name="expense_date" id="expense_date" value="{{ old('expense_date', date('Y-m-d')) }}"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('expense_date') border-red-500 @enderror"
                                       required>
                                @error('expense_date')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                            <textarea name="description" id="description" rows="3"
                                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('description') }}</textarea>
                        </div>

                        <!-- Type de partage -->
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Type de partage *</label>
                            <div class="flex space-x-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="split_type" value="equal" 
                                           {{ old('split_type', 'equal') == 'equal' ? 'checked' : '' }}
                                           class="form-radio" id="splitEqual">
                                    <span class="ml-2">Partage égal (tous les membres)</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="split_type" value="custom" 
                                           {{ old('split_type') == 'custom' ? 'checked' : '' }}
                                           class="form-radio" id="splitCustom">
                                    <span class="ml-2">Partage personnalisé</span>
                                </label>
                            </div>
                            @error('split_type')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Section partage personnalisé -->
                        <div id="customSplitSection" class="mb-4 p-4 bg-gray-50 rounded border {{ old('split_type') == 'custom' ? '' : 'hidden' }}">
                            <h4 class="font-medium mb-3">Qui doit combien ?</h4>
                            <p class="text-sm text-gray-600 mb-3">Entrez le montant que chaque membre doit rembourser :</p>
                            
                            @foreach($members as $member)
                                @if($member->id != Auth::id())
                                    <div class="flex items-center space-x-4 mb-3">
                                        <div class="w-32">
                                            <span class="text-gray-700 font-medium">{{ $member->name }}</span>
                                        </div>
                                        <div class="flex-1">
                                            <input type="number" 
                                                   step="0.01" 
                                                   name="amounts[]" 
                                                   value="{{ old('amounts.' . $loop->index) }}"
                                                   placeholder="Montant dû"
                                                   class="amount-input shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                   data-index="{{ $loop->index }}">
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                            <input type="hidden" name="debtors_count" value="{{ $members->count() - 1 }}">
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('colocations.show', $colocation) }}" 
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                                Annuler
                            </a>
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Ajouter la dépense
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const splitEqual = document.getElementById('splitEqual');
            const splitCustom = document.getElementById('splitCustom');
            const customSection = document.getElementById('customSplitSection');
            const amountInputs = document.querySelectorAll('.amount-input');

            // Fonction pour activer/désactiver les inputs
            function toggleInputs(disabled) {
                amountInputs.forEach(input => {
                    input.disabled = disabled;
                });
            }

            // Gestion des radios
            if (splitEqual) {
                splitEqual.addEventListener('change', function() {
                    customSection.classList.add('hidden');
                    toggleInputs(true); // Désactiver les inputs pour qu'ils ne soient pas envoyés
                });
            }

            if (splitCustom) {
                splitCustom.addEventListener('change', function() {
                    customSection.classList.remove('hidden');
                    toggleInputs(false); // Activer les inputs
                });
            }

            // État initial
            if (splitEqual && splitEqual.checked) {
                customSection.classList.add('hidden');
                toggleInputs(true);
            }
        });
    </script>

    <style>
        .hidden {
            display: none;
        }
    </style>
</x-app-layout>