@extends('layouts.app')

@section('title', 'Resep Favorit - ResepinAja')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('profile') }}" class="inline-flex items-center text-gray-600 hover:text-orange-500 transition">
            <i class="fas fa-arrow-left mr-2"></i>
            <span class="font-medium">Kembali ke Profil</span>
        </a>
    </div>

    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">
            <i class="fas fa-bookmark text-orange-500 mr-2"></i>
            Resep Favorit Saya
        </h1>
        <p class="text-gray-600 mt-2">Daftar resep yang telah Anda tandai sebagai favorit.</p>
    </div>

    <!-- Recipes Grid -->
    @if($recipes->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($recipes as $recipe)
                <a href="{{ route('recipes.show', ['recipe' => $recipe, 'from' => 'favorite']) }}" class="group">
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
            {{ $recipes->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <i class="fas fa-bookmark text-gray-300 text-6xl mb-4"></i>
            <p class="text-gray-500 text-lg">Anda belum menambahkan resep apa pun ke favorit.</p>
            <p class="text-gray-400 mt-2">Temukan resep favoritmu dan klik ikon bookmark di kartu resep!</p>
        </div>
    @endif
</div>
@endsection