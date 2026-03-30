<footer class="bg-gradient-to-r from-gray-900 to-gray-800 text-white mt-12 border-t border-gray-700">
    <div class="max-w-7xl mx-auto px-6 py-10">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <!-- App info -->
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <div class="text-[#78350f] p-2 rounded-xl shadow-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                        </svg>
                    </div>

                    <span class="font-bold text-xl text-[#78350f]">
                        EasyColoc
                    </span>
                </div>

                <p class="text-[#000000] leading-relaxed">
                    Simplifiez la gestion de votre colocation.
                </p>

                <!-- Social icons -->
                <div class="flex space-x-4 mt-4">
                    <a href="#" class="text-[#000000] hover:text-white transition">
                        <!-- Facebook -->
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>

                    <a href="#" class="text-[#000000] hover:text-white transition">
                        <!-- Twitter -->
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.937 4.937 0 004.604 3.417 9.868 9.868 0 01-6.102 2.104c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 0021.447-3.797 13.94 13.94 0 001.54-5.931c0-.212-.005-.424-.015-.636A9.93 9.93 0 0024 4.59z"/>
                        </svg>
                    </a>

                    <a href="#" class="text-[#000000] hover:text-white transition">
                        <!-- Github -->
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0C5.373 0 0 5.373 0 12c0 5.302 3.438 9.8 8.205 11.387.6.113.82-.26.82-.582 0-.287-.01-1.05-.015-2.06-3.338.726-4.042-1.61-4.042-1.61-.546-1.39-1.335-1.76-1.335-1.76-1.09-.746.082-.73.082-.73 1.205.085 1.84 1.237 1.84 1.237 1.07 1.834 2.807 1.304 3.492.997.108-.776.418-1.306.762-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.468-2.38 1.235-3.22-.123-.3-.535-1.52.117-3.16 0 0 1.008-.322 3.3 1.23.96-.267 1.98-.4 3-.405 1.02.005 2.04.138 3 .405 2.29-1.552 3.297-1.23 3.297-1.23.653 1.64.24 2.86.118 3.16.768.84 1.233 1.91 1.233 3.22 0 4.61-2.804 5.62-5.476 5.92.43.37.824 1.102.824 2.22 0 1.602-.015 2.894-.015 3.287 0 .322.216.698.83.576C20.565 21.795 24 17.3 24 12c0-6.627-5.373-12-12-12z"/>
                        </svg>
                    </a>
                </div>
            </div>
             
            <!-- Navigation -->
            <div>
                <h3 class="font-bold text-lg mb-4">Navigation</h3>
                <ul class="space-y-2 text-[#000000]">
                    <li><a href="{{ route('dashboard') }}" class="hover:text-white transition">Dashboard</a></li>
                    <li><a href="{{ route('colocations.index') }}" class="hover:text-white transition">Mes colocations</a></li>
                    <li><a href="{{ route('profile.edit') }}" class="hover:text-white transition">Mon profil</a></li>
                </ul>
            </div>

            <!-- Support -->
            <div>
                <h3 class="font-bold text-lg mb-4">Support</h3>
                <ul class="space-y-2 text-[#000000]">
                    <li>support@easycoloc.com</li>
                    <li>Centre d'aide</li>
                    <li>Documentation</li>
                </ul>
            </div>

        </div>

        <!-- Bottom -->
        <div class="mt-10 pt-6 border-t border-gray-700 text-center text-[#000000] text-sm">
            © {{ date('Y') }} EasyColoc — Tous droits réservés
        </div>

    </div>
</footer>