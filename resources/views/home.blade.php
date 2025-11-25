@extends('layouts.app')

@section('title', 'Beranda - ResepinAja')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-orange-400 to-red-500 rounded-lg shadow-lg p-8 mb-8 text-white">
        <h1 class="text-4xl font-bold mb-2">Selamat Datang di ResepinAja!</h1>
        <p class="text-lg">Temukan dan bagikan resep masakan favoritmu</p>
    </div>

    <!-- Search Bar -->
    <div class="mb-8">
        <form method="GET" action="{{ route('home') }}" class="max-w-2xl mx-auto">
            <div class="relative">
                <input type="text" 
                    name="search" 
                    value="{{ $search ?? '' }}"
                    placeholder="Cari resep... (contoh: nasi, ayam, goreng)"
                    class="w-full px-6 py-2.5 pr-12 text-base border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent shadow-sm">
                <button type="submit" 
                        class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-orange-500 hover:bg-orange-600 text-white px-5 py-1.5 rounded-full transition text-sm font-medium">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
        
        @if($search)
            <div class="max-w-2xl mx-auto mt-4 flex items-center justify-between">
                <p class="text-gray-600 text-sm">
                    Hasil pencarian untuk: <span class="font-bold text-orange-600">"{{ $search }}"</span>
                </p>
                <a href="{{ route('home') }}" class="text-blue-500 hover:text-blue-600 text-sm font-medium">
                    <i class="fas fa-times-circle mr-1"></i> Hapus pencarian
                </a>
            </div>
        @endif
    </div>

    <!-- Recipes Section Title -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">
            @if($search && $recipes->count() > 0)
                Hasil Pencarian
            @else
                Semua Resep
            @endif
        </h2>
    </div>

    @if($recipes->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($recipes as $recipe)
                <a href="{{ route('recipes.show', $recipe) }}" class="group">
                    <div class="recipe-card">
                        <!-- Recipe Image -->
                        <div class="recipe-card-image">
                            <img src="{{ $recipe->image_url }}" 
                                alt="{{ $recipe->title }}" 
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300"></div>
                        </div>
                        
                        <!-- Recipe Info -->
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-800 mb-2 line-clamp-1 group-hover:text-orange-500 transition">
                                {{ $recipe->title }}
                            </h3>
                            
                            <!-- Author Info -->
                            <div class="flex items-center mt-3">
                                <img src="{{ $recipe->user->photo_url }}" 
                                    alt="{{ $recipe->user->name }}" 
                                    class="avatar avatar-sm mr-2">
                                <div>
                                    <p class="text-sm text-gray-600">{{ $recipe->user->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $recipe->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $recipes->appends(['search' => $search])->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <i class="fas fa-search text-gray-300 text-6xl mb-4"></i>
            @if($search)
                <p class="text-gray-500 text-lg mb-2">Maaf, resep yang Anda cari tidak tersedia</p>
                <p class="text-gray-400 mb-4">Tidak ada resep yang cocok dengan "{{ $search }}"</p>
                
                @php
                    $allRecipes = \App\Models\Recipe::with('user')->latest()->paginate(12);
                @endphp
                
                @if($allRecipes->count() > 0)
                    <div class="mt-12">
                        <h3 class="text-2xl font-bold text-gray-800 mb-6">Semua Resep Tersedia</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                            @foreach($allRecipes as $recipe)
                                <a href="{{ route('recipes.show', $recipe) }}" class="group">
                                    <div class="recipe-card">
                                        <div class="recipe-card-image">
                                            <img src="{{ $recipe->image_url }}" 
                                                alt="{{ $recipe->title }}" 
                                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300"></div>
                                        </div>
                                        <div class="p-4">
                                            <h3 class="text-lg font-semibold text-gray-800 mb-2 line-clamp-1 group-hover:text-orange-500 transition">
                                                {{ $recipe->title }}
                                            </h3>
                                            <div class="flex items-center mt-3">
                                                <img src="{{ $recipe->user->photo_url }}" 
                                                    alt="{{ $recipe->user->name }}" 
                                                    class="avatar avatar-sm mr-2">
                                                <div>
                                                    <p class="text-sm text-gray-600">{{ $recipe->user->name }}</p>
                                                    <p class="text-xs text-gray-400">{{ $recipe->created_at->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            @else
                <p class="text-gray-500 text-lg">Belum ada resep. Jadilah yang pertama untuk berbagi!</p>
                @auth
                    <a href="{{ route('recipes.create') }}" class="inline-block mt-4 btn btn-primary">
                        <i class="fas fa-plus mr-2"></i> Upload Resep Pertama
                    </a>
                @endauth
            @endif
        </div>
    @endif
</div>
@endsection