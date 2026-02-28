<x-guest-layout>

<form method="POST" action="{{ route('register') }}">
@csrf

<div class="relative flex h-auto min-h-screen w-full flex-col bg-white overflow-x-hidden">

<!-- Hero -->
<div class="flex flex-col items-center justify-center px-4 pb-3 pt-8">
    <h1 class="text-3xl font-bold text-center bg-gradient-to-r from-[#78350f] via-[#b45309] to-[#f59e0b] bg-clip-text text-transparent">
        Rejoindre EasyColoc
    </h1>
    <p class="text-[#78350f] text-base pt-2 text-center max-w-[280px]">
        Gérez facilement les dépenses entre colocataires avec transparence.
    </p>
</div>

<!-- FORM -->
<div class="flex flex-col gap-1 px-4 py-4 max-w-[480px] mx-auto w-full">

<!-- Nom -->
<div class="flex flex-col w-full py-2">
<label>
<p class="text-sm font-semibold pb-2 text-gray-900">Nom complet</p>
<div class="relative flex items-center">
<input name="name"
value="{{ old('name') }}"
required autofocus
class="form-input w-full rounded-xl h-14 pl-12 border border-gray-300 focus:border-[#78350f] focus:ring-[#78350f]"
placeholder="nom prenom">
</div>
@error('name')
<p class="text-red-500 text-sm">{{ $message }}</p>
@enderror
</label>
</div>

<!-- Email -->
<div class="flex flex-col w-full py-2">
<label>
<p class="text-sm font-semibold pb-2 text-gray-900">Adresse e-mail</p>
<div class="relative flex items-center">
<input type="email"
name="email"
value="{{ old('email') }}"
required
class="form-input w-full rounded-xl h-14 pl-12 border border-gray-300 focus:border-[#78350f] focus:ring-[#78350f]"
placeholder="exemple@email.com">
</div>
@error('email')
<p class="text-red-500 text-sm">{{ $message }}</p>
@enderror
</label>
</div>

<!-- Mot de passe -->
<div class="flex flex-col w-full py-2">
<label>
<p class="text-sm font-semibold pb-2 text-gray-900">Mot de passe</p>
<div class="relative flex items-center">
<input type="password"
name="password"
required
class="form-input w-full rounded-xl h-14 pl-12 border border-gray-300 focus:border-[#78350f] focus:ring-[#78350f]"
placeholder="••••••••">
</div>
@error('password')
<p class="text-red-500 text-sm">{{ $message }}</p>
@enderror
</label>
</div>

<!-- Confirmation -->
<div class="flex flex-col w-full py-2">
<label>
<p class="text-sm font-semibold pb-2 text-gray-900">Confirmer le mot de passe</p>
<div class="relative flex items-center">
<input type="password"
name="password_confirmation"
required
class="form-input w-full rounded-xl h-14 pl-12 border border-gray-300 focus:border-[#78350f] focus:ring-[#78350f]"
placeholder="••••••••">
</div>
</label>
</div>

<!-- Button -->
<div class="pt-6">
<button type="submit"
class="w-full  py-4 flex items-center justify-center gap-2 from-[#78350f] via-[#b45309] to-[#f59e0b] text-white font-bold text-lg rounded-xl shadow-lg shadow-[#78350f]/20 hover:opacity-90 transition-all mt-2"
style="background-color:#78350f;">
<span>Créer mon compte</span>
</button>
</div>
<!-- Login -->
<div class="flex flex-col items-center gap-4 py-8 ">
<p class="text-sm text-gray-700">
Vous avez déjà un compte ?
<a href="{{ route('login') }}" class="font-bold" style="color:#b45309;">Se connecter</a>
</p>
</div>

</div>
</div>

</form>

</x-guest-layout>