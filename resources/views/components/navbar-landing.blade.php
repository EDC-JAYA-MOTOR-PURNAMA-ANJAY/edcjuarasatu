<nav class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <div class="flex items-center space-x-2">
                    <!-- Text Logo -->
                    <span class="text-2xl font-bold">
                        <span class="text-[#6A00B8]">edu</span>
                        <span class="text-[#FBBF24]">counsel</span>
                    </span>
                </div>
            </div>

            <!-- Navigation Menu - Center -->
            <div class="hidden md:flex items-center space-x-8 absolute left-1/2 transform -translate-x-1/2">
                <a href="#beranda" class="text-black font-medium hover:text-[#8B5CF6] transition duration-200">Beranda</a>
                <a href="#tentang" class="text-black font-medium hover:text-[#8B5CF6] transition duration-200">Tentang Kami</a>
                <a href="#fitur" class="text-black font-medium hover:text-[#8B5CF6] transition duration-200">Keunggulan</a>
                <a href="#faq" class="text-black font-medium hover:text-[#8B5CF6] transition duration-200">FAQ</a>
            </div>

            <!-- Search and Login - Right -->
            <div class="flex items-center space-x-4">
                <!-- Search Bar -->
                <div class="hidden lg:flex items-center bg-gray-100 rounded-full px-3 py-2 space-x-2">
                    <input
                        type="text"
                        id="search-input"
                        placeholder="Search"
                        class="bg-transparent border-none text-black placeholder-gray-500 focus:outline-none focus:ring-0 text-sm w-32"
                    >
                    <button id="search-btn" class="text-gray-500 hover:text-[#8B5CF6]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>

               <a href="{{ route('login') }}">
                    <button
                        id="login-btn"
                        class="bg-[#FBBF24] text-black px-6 py-2 rounded-full font-medium hover:bg-[#8B5CF6] hover:text-white transition duration-200"
                        style="border-radius: 20px; padding: 0.6rem 1.4rem;"
                    >
                        Login
                     </button>
                </a>
            </div>
        </div>
    </div>
</nav>
