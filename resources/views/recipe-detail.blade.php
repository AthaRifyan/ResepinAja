@extends('layouts.app')

@section('title', $recipe->title . ' - ResepinAja')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Dynamic Back Button -->
    <div class="mb-6">
        @if(isset($fromAdmin) && $fromAdmin)
            <a href="{{ route('admin.recipes') }}" class="inline-flex items-center text-gray-600 hover:text-orange-500 transition">
                <i class="fas fa-arrow-left mr-2"></i>
                <span class="font-medium">Kembali ke Kelola Resep User</span>
            </a>
        @elseif(isset($fromProfile) && $fromProfile)
            <a href="{{ route('profile') }}" class="inline-flex items-center text-gray-600 hover:text-orange-500 transition">
                <i class="fas fa-arrow-left mr-2"></i>
                <span class="font-medium">Kembali ke Profil</span>
            </a>
        @elseif(isset($fromFavorite) && $fromFavorite)
        <a href="{{ route('profile.favorites') }}" class="inline-flex items-center text-gray-600 hover:text-orange-500 transition">
            <i class="fas fa-arrow-left mr-2"></i>
            <span class="font-medium">Kembali ke Resep Favorit Saya</span>
        </a>
        @else
            <a href="{{ route('home') }}" class="inline-flex items-center text-gray-600 hover:text-orange-500 transition">
                <i class="fas fa-arrow-left mr-2"></i>
                <span class="font-medium">Kembali ke Beranda</span>
            </a>
        @endif
    </div>

    <!-- Recipe Card -->
    <div class="card">
        <!-- Recipe Image -->
        <div class="relative h-96">
            <img src="{{ $recipe->image_url }}" 
                alt="{{ $recipe->title }}" 
                class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
            <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                <h1 class="text-4xl font-bold mb-2">{{ $recipe->title }}</h1>
            </div>
        </div>

        <!-- Recipe Content -->
        <div class="p-6 md:p-8">
            <!-- Author Info -->
            <div class="flex items-center justify-between pb-6 border-b mb-6 flex-wrap gap-4">
                <div class="flex items-center">
                    <img src="{{ $recipe->user->photo_url }}" 
                        alt="{{ $recipe->user->name }}" 
                        class="avatar avatar-md mr-3">
                    <div>
                        <p class="font-semibold text-gray-800">{{ $recipe->user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $recipe->created_at->format('d M Y') }}</p>
                    </div>
                </div>
                
                <div class="flex gap-2 flex-wrap">
                <!-- Download PDF Button -->
                <a href="{{ route('recipes.download', $recipe) }}" 
                    class="inline-flex items-center bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                    <i class="fas fa-download mr-2"></i> Download PDF
                </a>

                @auth
                    <button type="button" 
                            onclick="toggleFavorite({{ $recipe->id }})"
                            class="inline-flex items-center bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition"
                            title="Tambahkan ke Favorit">
                        <i id="favorite-icon-{{ $recipe->id }}" 
                        class="fas fa-bookmark {{ auth()->user()->hasFavorited($recipe->id) ? 'text-pink-500' : 'text-gray-400' }}"></i>
                        <span class="ml-2">Favorit</span>
                    </button>

                    {{-- Tombol untuk Admin --}}
                    @if(isset($fromAdmin) && $fromAdmin)
                        <a href="{{ route('recipes.edit', ['recipe' => $recipe, 'from' => 'admin.recipes']) }}" 
                            class="inline-flex items-center bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                            <i class="fas fa-edit mr-2"></i> Edit Resep
                        </a>
                        
                        <form method="POST" action="{{ route('recipes.destroy', $recipe) }}" 
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus resep ini?')"
                            class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                                <i class="fas fa-trash mr-2"></i> Hapus Resep
                            </button>
                        </form>

                    @elseif(isset($fromProfile) && $fromProfile && $recipe->user_id === auth()->id())
                        <a href="{{ route('recipes.edit', $recipe) }}" 
                            class="inline-flex items-center bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                            <i class="fas fa-edit mr-2"></i> Edit Resep
                        </a>
                        
                        <form method="POST" action="{{ route('recipes.destroy', $recipe) }}" 
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus resep ini?')"
                            class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                                <i class="fas fa-trash mr-2"></i> Hapus Resep
                            </button>
                        </form>
                    @endif
                @endauth
            </div>
            </div>

            <!-- Ingredients Section -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-list-ul text-orange-500 mr-2"></i>
                    Bahan-Bahan
                </h2>
                <div class="bg-orange-50 rounded-lg p-6">
                    <ul class="space-y-2">
                        @foreach($recipe->ingredients as $ingredient)
                            <li class="flex items-start">
                                <i class="fas fa-check text-orange-500 mt-1 mr-3"></i>
                                <span class="text-gray-700">{{ $ingredient }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Steps Section -->
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-tasks text-orange-500 mr-2"></i>
                    Langkah-Langkah
                </h2>
                <div class="space-y-4">
                    @foreach($recipe->steps as $index => $step)
                        <div class="flex">
                            <div class="flex-shrink-0 w-10 h-10 bg-orange-500 text-white rounded-full flex items-center justify-center font-bold mr-4">
                                {{ $index + 1 }}
                            </div>
                            <div class="flex-1 bg-gray-50 rounded-lg p-4">
                                <p class="text-gray-700">{{ $step }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection