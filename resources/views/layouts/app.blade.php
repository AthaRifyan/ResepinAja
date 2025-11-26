<!DOCTYPE html>
<html lang="id">
<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        $isGuestPage = request()->routeIs(['login', 'register']);
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
        });
    }

    function confirmDeleteRecipe(recipeId, recipeTitle) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: `Resep "${recipeTitle}" akan dihapus secara permanen!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${recipeId}`).submit();
            }
        });
    }

    // Fungsi untuk menangani klik tombol hapus
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.btn-delete-recipe');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const recipeId = this.dataset.recipeId;
                const recipeTitle = this.dataset.recipeTitle;

                confirmDeleteRecipe(recipeId, recipeTitle);
            });
        });
    });

    function confirmDeleteUser(userId, userName) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: `Akun "${userName}" akan dihapus secara permanen! Semua resep milik user ini juga akan ikut terhapus.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika dikonfirmasi, submit form penghapusan
                document.getElementById(`delete-user-form-${userId}`).submit();
            }
        });
    }

    // Tangani klik tombol hapus user
    document.addEventListener('DOMContentLoaded', function() {

        const deleteUserButtons = document.querySelectorAll('.btn-delete-user');

        deleteUserButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const userId = this.dataset.userId;
                const userName = this.dataset.userName;

                confirmDeleteUser(userId, userName);
            });
        });
    });

    </script>
</body>
</html>