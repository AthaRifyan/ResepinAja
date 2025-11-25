<!-- Header -->
<header class="header">
    <div class="header-content">
        <!-- Logo -->
        <div class="header-logo">
            <a href="{{ route('home') }}" class="text-2xl font-bold text-orange-500 hover:text-orange-600 transition">
                <i class="fas fa-utensils mr-2"></i>ResepinAja
            </a>
        </div>

        <!-- Right Section -->
        <div class="header-right">
            @guest
                <!-- Login Button for Guest -->
                <a href="{{ route('login') }}" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt mr-2"></i>Login
                </a>
            @else
                <!-- User Profile Section -->
                <div class="flex items-center gap-4">
                    <!-- Profile Info - Clickable -->
                    <a href="{{ route('profile') }}" class="btn-profile">
                        <img src="{{ Auth::user()->photo_url }}" 
                            alt="{{ Auth::user()->name }}" 
                            class="avatar avatar-sm">
                        <span class="text-sm font-medium hidden md:block">
                            {{ Auth::user()->name }}
                        </span>
                    </a>

                    <!-- Logout Button -->
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="btn btn-danger h-10 flex items-center justify-center">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            <span class="hidden md:inline">Logout</span>
                        </button>
                    </form>
                </div>
            @endguest
        </div>

        <!-- Mobile Menu Button -->
        <button onclick="toggleSidebar()" class="mobile-menu-btn">
            <i class="fas fa-bars text-xl"></i>
        </button>
    </div>
</header>