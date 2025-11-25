<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ResepinAja')</title>
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    @stack('styles')
</head>
<body class="bg-gray-50 @yield('body-class', '')">
    @php
        // Tentukan apakah halaman ini adalah halaman guest (tanpa sidebar)
        $isGuestPage = request()->routeIs(['login', 'register']); // Tambahkan route lain yang ingin dianggap sebagai guest page
        // Contoh lain yang bisa ditambahkan:
        // $isGuestPage = request()->routeIs(['login', 'register', 'forgot.password', 'reset.password']);
    @endphp

    @if($isGuestPage)
        <!-- Guest Layout (Full Width, No Sidebar) -->
        <div class="min-h-screen flex flex-col">
            <!-- Flash Messages -->
            @include('components.flash-messages')

            <!-- Page Content -->
            <div class="flex-1">
                @yield('content')
            </div>
        </div>
    @else
        <!-- Standard Layout (With Header, Sidebar, Main Content) -->
        <!-- Include Header -->
        @include('components.header')

        <div class="main-container flex-1">
            <!-- Include Sidebar -->
            @include('components.sidebar')

            <!-- Main Content -->
            <main class="main-content">
                <!-- Flash Messages -->
                @include('components.flash-messages')

                <!-- Page Content -->
                <div class="fade-in">
                    @yield('content')
                </div>
            </main>
        </div>

        <!-- Include Footer -->
        @include('components.footer')
    @endif
    
    <!-- Include Scripts -->
    @include('components.scripts')
    
    @stack('scripts')

    <script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        
        if (sidebar && overlay) {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }
    }

    // Close sidebar when clicking on a link (optional, untuk UX lebih baik)
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarLinks = document.querySelectorAll('.sidebar-link');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        
        sidebarLinks.forEach(link => {
            link.addEventListener('click', function() {
                // Hanya tutup sidebar di mobile
                if (window.innerWidth < 1024) {
                    if (sidebar && overlay) {
                        sidebar.classList.remove('active');
                        overlay.classList.remove('active');
                    }
                }
            });
        });
    });

    function toggleFavorite(recipeId) {
        fetch(`{{ route('recipes.favorite', ['recipe' => ':recipeId']) }}`.replace(':recipeId', recipeId), {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
            },
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            const icon = document.getElementById(`favorite-icon-${recipeId}`);
            if (data && data.status === 'added') {
                // Ganti kelas saat ditambahkan ke favorit
                icon.classList.remove('text-gray-400');
                icon.classList.add('text-pink-500');
            } else if (data && data.status === 'removed') {
                // Ganti kelas saat dihapus dari favorit
                icon.classList.remove('text-pink-500');
                icon.classList.add('text-gray-400');
            } else {
                console.error('Invalid response:', data);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Tampilkan pesan kesalahan di konsol, bukan alert
        });
    }
    </script>
</body>
</html>