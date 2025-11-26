@extends('layouts.app')

@section('title', 'Profil - ResepinAja')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Profile Header -->
    <div class="card p-8 mb-8">
        <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
            <!-- Profile Photo -->
            <div class="flex-shrink-0">
                <img src="{{ $user->photo_url }}" 
                    alt="{{ $user->name }}" 
                    class="avatar avatar-lg border-4 border-orange-500">
            </div>
            
            <!-- Profile Info -->
            <div class="flex-1 text-center md:text-left">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $user->name }}</h1>
                <p class="text-gray-600 mb-4">{{ $user->email }}</p>
                
                <div class="flex flex-wrap gap-4 justify-center md:justify-start text-sm mb-4">
                    <div class="bg-orange-50 px-4 py-2 rounded-lg">
                        <span class="font-semibold text-orange-600">{{ $recipes->count() }}</span>
                        <span class="text-gray-600"> Resep</span>
                    </div>
                    <div class="bg-blue-50 px-4 py-2 rounded-lg">
                        <span class="font-semibold text-blue-600">Bergabung sejak</span>
                        <span class="text-gray-600"> {{ $user->created_at->format('M Y') }}</span>
                    </div>
                </div>

                <!-- Edit Profile Button -->
                <a href="{{ route('profile.edit') }}" class="inline-flex items-center bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg font-medium transition">
                    <i class="fas fa-edit mr-2"></i> Edit Akun
                </a>

                <!-- Link Resep Favorit -->
                <a href="{{ route('profile.favorites') }}" class="inline-flex items-center bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded-lg font-medium transition">
                    <i class="fas fa-bookmark mr-2"></i> Resep Favorit
                </a>

            </div>
        </div>
    </div>

    <!-- My Recipes Section -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Resep Saya</h2>
    </div>

    @if($recipes->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($recipes as $recipe)
                <div class="recipe-card group">
                    <!-- Recipe Image (Clickable) -->
                    <a href="{{ route('recipes.show', ['recipe' => $recipe, 'from' => 'profile']) }}" class="block">
                        <div class="recipe-card-image">
                            <img src="{{ $recipe->image_url }}" 
                                alt="{{ $recipe->title }}" 
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300"></div>
                        </div>
                    </a>
                    
                    <!-- Recipe Info -->
                    <div class="p-4">
                        <a href="{{ route('recipes.show', ['recipe' => $recipe, 'from' => 'profile']) }}">
                            <h3 class="text-lg font-semibold text-gray-800 mb-2 line-clamp-1 group-hover:text-orange-500 transition">
                                {{ $recipe->title }}
                            </h3>
                        </a>
                        
                        <p class="text-sm text-gray-500 mb-3">
                            <i class="far fa-calendar mr-1"></i>
                            {{ $recipe->created_at->format('d M Y') }}
                        </p>

                        <!-- Action Buttons -->
                        <div class="grid grid-cols-2 gap-2">
                            <a href="{{ route('recipes.edit', ['recipe' => $recipe, 'from' => 'profile']) }}" 
                                class="btn bg-blue-500 hover:bg-blue-600 text-white text-center text-sm">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                            
                            <button 
                                type="button" 
                                class="btn btn-danger w-full text-sm btn-delete-recipe"
                                data-recipe-id="{{ $recipe->id }}"
                                data-recipe-title="{{ $recipe->title }}"
                                title="Hapus Resep">
                                <i class="fas fa-trash mr-1"></i> Hapus
                            </button>

                            <form id="delete-form-{{ $recipe->id }}" method="POST" action="{{ route('recipes.destroy', $recipe) }}" class="inline">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="card p-12 text-center">
            <i class="fas fa-utensils text-gray-300 text-6xl mb-4"></i>
            <p class="text-gray-500 text-lg mb-4">Anda belum memiliki resep.</p>
            <a href="{{ route('recipes.create') }}" class="btn btn-primary inline-block">
                <i class="fas fa-plus mr-2"></i> Upload Resep Pertama
            </a>
        </div>
    @endif
</div>
@endsection