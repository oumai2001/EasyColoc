<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Catégories - {{ $colocation->name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('categories.create', $colocation) }}" 
                   class="bg-gradient-to-r from-amber-600 to-amber-700 text-white px-4 py-2 rounded-lg text-sm hover:shadow-lg transition">
                    + Nouvelle catégorie
                </a>
                <a href="{{ route('colocations.show', $colocation) }}" 
                   class="text-gray-600 hover:text-gray-800 px-4 py-2">
                    ← Retour
                </a>
            </div>
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

            <!-- Catégories par défaut -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
                <div class="px-6 py-4 bg-gray-50 border-b">
                    <h3 class="font-medium text-gray-700">Catégories par défaut</h3>
                </div>
                <div class="p-6">
                    @php
                        $defaultCategories = $categories->whereNull('colocation_id');
                    @endphp
                    @if($defaultCategories->count() > 0)
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach($defaultCategories as $category)
                                <div class="flex items-center space-x-2 p-3 bg-gray-50 rounded-lg">
                                    <div class="w-4 h-4 rounded-full" style="background-color: {{ $category->color }}"></div>
                                    <span>{{ $category->name }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center">Aucune catégorie par défaut</p>
                    @endif
                </div>
            </div>

            <!-- Catégories personnalisées -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b">
                    <h3 class="font-medium text-gray-700">Mes catégories</h3>
                </div>
                <div class="p-6">
                    @php
                        $customCategories = $categories->where('colocation_id', $colocation->id);
                    @endphp

                    @if($customCategories->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($customCategories as $category)
                                <div class="border rounded-lg p-4 hover:shadow-md transition">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-6 h-6 rounded-full" style="background-color: {{ $category->color }}"></div>
                                            <div>
                                                <p class="font-medium">{{ $category->name }}</p>
                                                <p class="text-xs text-gray-500">
                                                    {{ $category->expenses->count() }} dépense(s)
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('categories.edit', [$colocation, $category]) }}" 
                                               class="text-amber-600 hover:text-amber-800">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            @if($category->expenses->count() == 0)
                                                <form action="{{ route('categories.destroy', [$colocation, $category]) }}" 
                                                      method="POST"
                                                      onsubmit="return confirm('Supprimer cette catégorie ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">
                            Vous n'avez pas encore créé de catégories personnalisées.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>