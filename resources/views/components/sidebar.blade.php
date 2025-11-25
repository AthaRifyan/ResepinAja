<!-- Sidebar -->
<aside id="sidebar" class="sidebar">
    <nav class="sidebar-nav">
        <!-- Main Navigation -->
        <div class="sidebar-section">
            <a href="{{ route('home') }}" class="sidebar-link {{ 
                request()->routeIs('home') || 
                (request()->routeIs('recipes.show') && !request()->query('from')) 
                ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span>Beranda</span>
            </a>

            @auth
                <a href="{{ route('recipes.create') }}" class="sidebar-link {{ request()->routeIs('recipes.create') ? 'active' : '' }}">
                    <i class="fas fa-plus-circle"></i>
                    <span>Upload Resep</span>
                </a>

                <a href="{{ route('chat.index') }}" class="sidebar-link {{ request()->routeIs('chat.index') ? 'active' : '' }}">
                    <i class="fas fa-comments"></i>
                    <span>Chat ResepinBot</span>
                </a>
            @endauth
        </div>

        <!-- Admin Section (Hanya untuk Admin) -->
        @auth
            @php
                $user = Auth::user();
            @endphp
            @if($user && $user->isAdmin())
                <div class="sidebar-section">
                    <div class="sidebar-section-title">
                        <i class="fas fa-shield-alt mr-2"></i>Admin
                    </div>
                    
                    <a href="{{ route('admin.users') }}" class="sidebar-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        <span>Kelola Akun User</span>
                    </a>

                    <a href="{{ route('admin.recipes') }}" class="sidebar-link {{ 
                        request()->routeIs('admin.recipes*') || 
                        (request()->routeIs('recipes.show') && request()->query('from') === 'admin.recipes') ||
                        (request()->routeIs('recipes.edit') && request()->query('from') === 'admin.recipes')
                        ? 'active' : '' }}">
                        <i class="fas fa-utensils"></i>
                        <span>Kelola Resep User</span>
                    </a>
                </div>
            @endif
        @endauth

        <!-- Profile Section (Mobile Only - untuk Guest & User) -->
        <div class="sidebar-section sidebar-mobile-only">
            <div class="sidebar-section-title">
                <i class="fas fa-user mr-2"></i>Profil
            </div>
            
            @auth
                <!-- Profile Link with Avatar (untuk user yang login) -->
                <a href="{{ route('profile') }}" class="sidebar-link {{ request()->routeIs('profile') ? 'active' : '' }}">
                    <img src="{{ Auth::user()->photo_url }}" 
                        alt="{{ Auth::user()->name }}" 
                        class="w-6 h-6 rounded-full object-cover border-2 border-gray-200">
                    <span>{{ Auth::user()->name }}</span>
                </a>

                <!-- Logout Button -->
                <form method="POST" action="{{ route('logout') }}" class="mt-1">
                    @csrf
                    <button type="submit" class="sidebar-logout-btn w-full text-left flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 mb-1">
                        <i class="fas fa-sign-out-alt text-lg w-5"></i>
                        <span>Logout</span>
                    </button>
                </form>
            @else
                <!-- Login Button for Guest -->
                <a href="{{ route('login') }}" class="sidebar-link">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Login</span>
                </a>
            @endauth
        </div>
                
    </nav>
</aside>

<!-- Overlay for mobile -->
<div id="sidebar-overlay" class="sidebar-overlay" onclick="toggleSidebar()"></div>