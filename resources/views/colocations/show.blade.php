<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center bg-gradient-to-r from-amber-800 to-amber-700 p-4 rounded-t-lg">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ $colocation->name }}
            </h2>
            <a href="{{ route('colocations.index') }}" class="text-amber-200 hover:text-white transition">
                ← Retour
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-amber-50">
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

            <!-- Infos de la colocation -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6 border border-amber-200">
                <div class="bg-gradient-to-r from-amber-800 to-amber-700 px-6 py-3">
                    <h3 class="text-lg font-medium text-white">Informations</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-amber-800 font-medium">Propriétaire</p>
                            <p class="text-gray-800">{{ $colocation->owner->name }}</p>
                        </div>
                        <div>
                            <p class="text-amber-800 font-medium">Statut</p>
                            <p class="font-medium">
                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded">
                                    {{ $colocation->status }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <p class="text-amber-800 font-medium">Membres actifs</p>
                            <p class="text-gray-800">{{ $members->count() }}</p>
                        </div>
                        <div>
                            <p class="text-amber-800 font-medium">Créée le</p>
                            <p class="text-gray-800">{{ $colocation->created_at->format('d/m/Y') }}</p>
                        </div>
                    </div>
                    
                    @if($colocation->isOwner(Auth::user()))
                        <div class="mt-4">
                            <a href="{{ route('colocations.edit', $colocation) }}" 
                               class="bg-gradient-to-r from-amber-600 to-amber-700 text-white px-4 py-2 rounded-lg text-sm hover:shadow-lg transition inline-flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Modifier la colocation
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- SECTION SOLDES ET REMBOURSEMENTS -->
            @php
                $balances = \App\Http\Controllers\ExpenseController::calculateBalances($colocation);
                $settlements = \App\Http\Controllers\ExpenseController::calculateSettlements($colocation);
                $expenses = $colocation->expenses()->with(['payer', 'category'])->latest('expense_date')->get();
            @endphp

            <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6 border border-amber-200">
                <div class="bg-gradient-to-r from-amber-800 to-amber-700 px-6 py-3">
                    <h3 class="text-lg font-medium text-white">Soldes et remboursements</h3>
                </div>
                <div class="p-6">
                    
                    @if(!empty($balances) && count($balances) > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                            @foreach($balances as $balance)
                                <div class="border rounded-lg p-4 {{ $balance['balance'] >= 0 ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200' }}">
                                    <p class="font-medium text-amber-900">{{ $balance['user']->name }}</p>
                                    <div class="flex justify-between text-sm mt-2">
                                        <span class="text-amber-800">Payé:</span>
                                        <span class="text-gray-800 font-medium">{{ number_format($balance['paid'], 2) }} €</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-amber-800">Dû:</span>
                                        <span class="text-gray-800 font-medium">{{ number_format($balance['owed'], 2) }} €</span>
                                    </div>
                                    <div class="flex justify-between text-lg font-bold mt-2">
                                        <span class="text-amber-800">Solde:</span>
                                        <span class="{{ $balance['balance'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ number_format($balance['balance'], 2) }} €
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-amber-700">
                            Aucune dépense pour le moment. Les soldes apparaîtront ici.
                        </div>
                    @endif

                    <!-- Remboursements simplifiés avec boutons Marquer payé -->
                    @if(!empty($settlements) && count($settlements) > 0)
                        <h4 class="font-medium text-amber-900 mb-3">Qui doit à qui :</h4>
                        <div class="space-y-2">
                            @foreach($settlements as $settlement)
                                <div class="flex items-center justify-between bg-amber-50 p-3 rounded-lg hover:bg-amber-100 transition border border-amber-200">
                                    <div class="flex items-center space-x-2">
                                        <span class="font-medium text-red-600">{{ $settlement['from']->name }}</span>
                                        <svg class="w-4 h-4 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                        </svg>
                                        <span class="font-medium text-green-600">{{ $settlement['to']->name }}</span>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <span class="font-bold text-amber-900">{{ number_format($settlement['amount'], 2) }} €</span>
                                        
                                        @php
                                            $user = Auth::user();
                                            $canMark = ($user->id == $settlement['from']->id || $user->id == $settlement['to']->id);
                                        @endphp
                                        
                                        @if($canMark)
                                            <form action="{{ route('payments.settlement', $colocation) }}" 
                                                  method="POST" 
                                                  class="inline"
                                                  onsubmit="return confirm('Confirmer le paiement de {{ number_format($settlement['amount'], 2) }} € de {{ $settlement['from']->name }} à {{ $settlement['to']->name }} ?')">
                                                @csrf
                                                <input type="hidden" name="from_user_id" value="{{ $settlement['from']->id }}">
                                                <input type="hidden" name="to_user_id" value="{{ $settlement['to']->id }}">
                                                <input type="hidden" name="amount" value="{{ $settlement['amount'] }}">
                                                
                                                @if($user->id == $settlement['from']->id)
                                                    <button type="submit" 
                                                            class="bg-gradient-to-r from-amber-600 to-amber-700 hover:from-amber-700 hover:to-amber-800 text-white text-sm px-4 py-2 rounded-lg transition flex items-center shadow-md">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                        Marquer payé
                                                    </button>
                                                @else
                                                    <button type="submit" 
                                                            class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white text-sm px-4 py-2 rounded-lg transition flex items-center shadow-md">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        Confirmer réception
                                                    </button>
                                                @endif
                                            </form>
                                        @else
                                            <span class="text-sm text-amber-500">(En attente)</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Historique des paiements récents -->
                        @php
                            $recentPayments = \App\Models\Payment::where('colocation_id', $colocation->id)
                                                ->with(['fromUser', 'toUser'])
                                                ->latest('paid_at')
                                                ->take(5)
                                                ->get();
                        @endphp

                        @if($recentPayments->count() > 0)
                            <div class="mt-8 pt-6 border-t border-amber-200">
                                <h4 class="font-medium text-amber-900 mb-3">Paiements récents</h4>
                                <div class="space-y-2">
                                    @foreach($recentPayments as $payment)
                                        <div class="flex items-center justify-between bg-green-50 p-3 rounded-lg border border-green-200">
                                            <div class="flex items-center space-x-2">
                                                <span class="font-medium text-amber-900">{{ $payment->fromUser->name }}</span>
                                                <svg class="w-4 h-4 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                                </svg>
                                                <span class="font-medium text-amber-900">{{ $payment->toUser->name }}</span>
                                                <span class="text-sm text-amber-600 ml-2">
                                                    ({{ $payment->paid_at->format('d/m/Y H:i') }})
                                                </span>
                                            </div>
                                            <span class="font-bold text-green-600">{{ number_format($payment->amount, 2) }} €</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            <!-- Liste des membres -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6 border border-amber-200">
                <div class="bg-gradient-to-r from-amber-800 to-amber-700 px-6 py-3">
                    <h3 class="text-lg font-medium text-white">Membres de la colocation</h3>
                </div>
                <div class="p-6">
                    
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-b border-amber-200">
                                <th class="text-left py-3 text-amber-800 font-medium">Membre</th>
                                <th class="text-left py-3 text-amber-800 font-medium">Rôle</th>
                                <th class="text-left py-3 text-amber-800 font-medium">Arrivée</th>
                                <th class="text-left py-3 text-amber-800 font-medium">Réputation</th>
                                @if($colocation->isOwner(Auth::user()))
                                    <th class="text-left py-3 text-amber-800 font-medium">Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($members as $member)
                                <tr class="border-b border-amber-100">
                                    <td class="py-3">
                                        <div class="flex items-center">
                                            @if($member->avatar)
                                                <img src="{{ Storage::url($member->avatar) }}" 
                                                     alt="{{ $member->name }}" 
                                                     class="w-8 h-8 rounded-full mr-2 object-cover border-2 border-amber-300">
                                            @else
                                                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-amber-600 to-amber-700 mr-2 flex items-center justify-center border-2 border-amber-300">
                                                    <span class="text-sm font-medium text-white">{{ substr($member->name, 0, 1) }}</span>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="font-medium text-amber-900">{{ $member->name }}</p>
                                                <p class="text-xs text-amber-600">{{ $member->pseudo ?? '' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <span class="px-2 py-1 {{ $member->pivot->role == 'owner' ? 'bg-purple-100 text-purple-800' : 'bg-amber-100 text-amber-800' }} rounded-full text-sm">
                                            {{ $member->pivot->role }}
                                        </span>
                                    </td>
                                    <td class="py-3 text-amber-800">{{ \Carbon\Carbon::parse($member->pivot->joined_at)->format('d/m/Y') }}</td>
                                    <td class="py-3">
                                        <span class="px-2 py-1 {{ $member->reputation >= 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} rounded-full text-sm font-medium">
                                            {{ $member->reputation }}
                                        </span>
                                    </td>
                                    @if($colocation->isOwner(Auth::user()) && $member->id != Auth::id())
                                        <td class="py-3">
                                            <form action="{{ route('colocations.remove-member', [$colocation, $member]) }}" 
                                                  method="POST" 
                                                  class="inline"
                                                  onsubmit="return confirm('Êtes-vous sûr de vouloir retirer {{ $member->name }} ?\n\nS\'il a des dettes, elles seront transférées à votre compte.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    Retirer
                                                </button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if($colocation->isOwner(Auth::user()))
                        <div class="mt-6 pt-6 border-t border-amber-200">
                            <h4 class="font-medium text-amber-900 mb-4">Inviter des membres</h4>
                            
                            <form action="{{ route('invitations.store', $colocation) }}" method="POST" class="mb-4">
                                @csrf
                                <div class="flex gap-2">
                                    <input type="email" 
                                           name="email" 
                                           placeholder="Email de la personne à inviter" 
                                           class="flex-1 rounded-lg border-amber-300 shadow-sm focus:border-amber-500 focus:ring focus:ring-amber-200 focus:ring-opacity-50 px-4 py-2"
                                           required>
                                    <button type="submit" 
                                            class="bg-gradient-to-r from-amber-600 to-amber-700 text-white font-bold py-2 px-6 rounded-lg hover:shadow-lg transition flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Envoyer
                                    </button>
                                </div>
                            </form>

                            @php
                                $pendingInvitations = $colocation->invitations()->where('status', 'pending')->get();
                            @endphp
                            
                            @if($pendingInvitations->count() > 0)
                                <h5 class="font-medium text-sm text-amber-700 mb-2">Invitations en attente :</h5>
                                <div class="space-y-2">
                                    @foreach($pendingInvitations as $invitation)
                                        <div class="flex items-center justify-between bg-amber-50 p-3 rounded-lg border border-amber-200">
                                            <div>
                                                <span class="text-sm text-amber-900">{{ $invitation->email }}</span>
                                                <span class="text-xs text-amber-600 ml-2">
                                                    (Expire le {{ \Carbon\Carbon::parse($invitation->expires_at)->format('d/m/Y') }})
                                                </span>
                                            </div>
                                            <form action="{{ route('invitations.destroy', $invitation) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-600 hover:text-red-800 text-sm flex items-center"
                                                        onclick="return confirm('Annuler cette invitation ?')">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                    Annuler
                                                </button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- Liste des dépenses -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-amber-200">
                <div class="bg-gradient-to-r from-amber-800 to-amber-700 px-6 py-3">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-medium text-white">Dépenses</h3>
                        <div class="flex space-x-2">
                            <a href="{{ route('categories.index', $colocation) }}" 
                               class="bg-amber-200 text-amber-800 hover:bg-amber-300 px-4 py-2 rounded-lg text-sm font-medium transition flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-5-5A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                Catégories
                            </a>
                            <a href="{{ route('expenses.create', $colocation) }}" 
                               class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-2 px-4 rounded-lg text-sm flex items-center shadow-md">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Ajouter
                            </a>
                        </div>
                    </div>
                </div>
                <div class="p-6">

                    @if($expenses->count() > 0)
                        <div class="space-y-3">
                            @foreach($expenses as $expense)
                                <div class="border border-amber-200 rounded-lg p-4 hover:shadow-md transition bg-amber-50">
                                    <div class="flex justify-between items-start">
                                        <div class="flex items-start space-x-3">
                                            <div class="w-2 h-12 rounded-full" style="background-color: {{ $expense->category->color ?? '#78350f' }}"></div>
                                            <div>
                                                <a href="{{ route('expenses.show', [$colocation, $expense]) }}" class="font-medium text-amber-900 hover:text-amber-700">
                                                    {{ $expense->title }}
                                                </a>
                                                <p class="text-sm text-amber-700">
                                                    Payé par {{ $expense->payer->name }} le {{ $expense->expense_date->format('d/m/Y') }}
                                                </p>
                                                <div class="flex items-center space-x-2 mt-1">
                                                    <span class="text-xs px-2 py-1 bg-amber-200 text-amber-800 rounded-full">
                                                        {{ $expense->category->name }}
                                                    </span>
                                                    <span class="text-xs text-amber-600">
                                                        {{ $expense->split_type == 'equal' ? 'Partage égal' : 'Partage personnalisé' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-lg font-bold text-amber-900">{{ number_format($expense->amount, 2) }} €</p>
                                            @php
                                                $remaining = $expense->debtors->where('pivot.is_paid', false)->sum('pivot.amount_owed');
                                            @endphp
                                            @if($remaining > 0)
                                                <p class="text-xs text-orange-600 font-medium">
                                                    Reste: {{ number_format($remaining, 2) }} €
                                                </p>
                                            @else
                                                <p class="text-xs text-green-600 font-medium">
                                                    ✓ Remboursé
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-amber-700 text-center py-8">Aucune dépense pour le moment.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>