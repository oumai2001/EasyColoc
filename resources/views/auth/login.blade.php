<x-guest-layout>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Hero Section -->
        <div class="flex flex-col items-center justify-center px-4 pb-3 pt-8">
            <h1 class="text-3xl font-bold text-center bg-gradient-to-r from-[#78350f] via-[#b45309] to-[#f59e0b] bg-clip-text text-transparent">
                Bienvenue sur EasyColoc
            </h1>
            <p class="text-[#78350f] text-base pt-2 text-center max-w-[280px]">
                Gérez vos dépenses et votre colocation en toute simplicité.
            </p>
        </div>

        <!-- Form Fields -->
        <div class="flex flex-col gap-4 px-4 py-4 max-w-[480px] mx-auto w-full">

            <!-- Email -->
            <div class="flex flex-col w-full">
                <label class="text-sm font-semibold pb-2 text-[#000000]">Adresse e-mail</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="form-input w-full rounded-xl h-14 pl-4 border border-[#b45309] placeholder-[#696867] focus:border-[#78350f] focus:ring-[#78350f] text-[#78350f]"
                       placeholder="exemple@email.com">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="flex flex-col w-full">
                <label class="text-sm font-semibold pb-2 text-[#000000]">Mot de passe</label>
                <input id="password" type="password" name="password" required
                       class="form-input w-full rounded-xl h-14 pl-4 border border-[#b45309] placeholder-[#696867] focus:border-[#78350f] focus:ring-[#78350f] text-[#78350f]"
                       placeholder="••••••••">
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between py-1">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded text-[#78350f] focus:ring-[#78350f] border-[#b45309]">
                    <span class="text-sm text-[#b45309]">Se souvenir de moi</span>
                </label>
                <a class="text-sm font-semibold text-[#b45309] hover:underline" href="#">Mot de passe oublié ?</a>
            </div>

            <!-- Submit -->
            <button type="submit"
                    class="w-full h-14 bg-gradient-to-r from-[#78350f] via-[#b45309] to-[#f59e0b] text-white font-bold text-lg rounded-xl shadow-lg shadow-[#78350f]/20 hover:opacity-90 transition-all mt-2">
                Se connecter
            </button>

            <!-- Signup Link -->
            <p class="text-center text-[#000000] text-sm mt-4">
                Pas encore de compte ?
                <a href="{{ route('register') }}" class="font-bold underline text-[#78350f] ">Créer un compte</a>
            </p>

        </div>
    </form>
</x-guest-layout>