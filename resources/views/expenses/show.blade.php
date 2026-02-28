<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $expense->title }} - {{ $colocation->name }}
            </h2>
            <a href="{{ route('colocations.show', $colocation) }}" class="text-blue-500 hover:text-blue-700">
                ← Retour à la colocation
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Détails de la dépense -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-600">Montant total</p>
                            <p class="text-2xl font-bold">{{ number_format($expense->amount, 2) }} €</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Payé par</p>
                            <p class="font-medium">{{ $expense->payer->name }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Date</p>
                            <p>{{ $expense->expense_date->format('d/m/Y') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Catégorie</p>
                            <p>
                                <span class="px-2 py-1 rounded text-white" style="background-color: {{ $expense->category->color }}">
                                    {{ $expense->category->name }}
                                </span>
                            </p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-gray-600">Description</p>
                            <p>{{ $expense->description ?? 'Aucune description' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Qui doit quoi -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium mb-4">Remboursements</h3>
                    
                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th class="text-left">Personne</th>
                                <th class="text-left">Montant dû</th>
                                <th class="text-left">Statut</th>
                                <th class="text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($expense->debtors as $debtor)
                                <tr>
                                    <td>{{ $debtor->name }}</td>
                                    <td>{{ number_format($debtor->pivot->amount_owed, 2) }} €</td>
                                    <td>
                                        @if($debtor->pivot->is_paid)
                                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded">
                                                Payé le {{ \Carbon\Carbon::parse($debtor->pivot->paid_at)->format('d/m/Y') }}
                                            </span>
                                        @else
                                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded">
                                                En attente
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(!$debtor->pivot->is_paid && (Auth::id() == $expense->user_id || Auth::id() == $debtor->id))
                                            <form action="{{ route('expenses.mark-paid', [$colocation, $expense, $debtor]) }}" method="POST">
                                                @csrf
                                                <button type="submit" 
                                                        class="bg-blue-500 hover:bg-blue-700 text-white text-sm px-3 py-1 rounded"
                                                        onclick="return confirm('Confirmer le paiement de {{ $debtor->name }} ?')">
                                                    Marquer payé
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if($expense->isFullyPaid())
                        <div class="mt-4 p-4 bg-green-100 text-green-700 rounded">
                            ✅ Tous les remboursements ont été effectués !
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>