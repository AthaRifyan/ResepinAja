@extends('layouts.app')

@section('title', 'Edit Resep - ResepinAja')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="card p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 flex items-center">
            <i class="fas fa-edit text-blue-500 mr-3"></i>
            Edit Resep
        </h1>

        <form method="POST" action="{{ route('recipes.update', $recipe) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div class="mb-6">
                <label for="title" class="block text-gray-700 font-semibold mb-2">
                    Nama Masakan <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                    id="title" 
                    name="title" 
                    value="{{ old('title', $recipe->title) }}"
                    class="input"
                    placeholder="Contoh: Nasi Goreng Spesial"
                    required>
            </div>

            <!-- Current Image -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Foto Saat Ini</label>
                <img src="{{ $recipe->image_url }}" 
                    alt="{{ $recipe->title }}"
                    id="current-image" 
                    class="w-full h-64 object-cover rounded-lg">
            </div>

            <!-- Image -->
            <div class="mb-6">
                <label for="image" class="block text-gray-700 font-semibold mb-2">
                    Ganti Foto Masakan (Opsional)
                </label>
                <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-6 hover:border-blue-500 transition">
                    <input type="file" 
                        id="image" 
                        name="image" 
                        accept="image/*"
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                        onchange="previewImage(this)">
                    <div class="text-center">
                        <i class="fas fa-cloud-upload-alt text-gray-400 text-4xl mb-2"></i>
                        <p class="text-gray-600">Klik atau drag foto masakan di sini</p>
                        <p class="text-sm text-gray-400 mt-1">Format: JPG, PNG (Max: 2MB)</p>
                    </div>
                </div>
                <div id="image-preview" class="mt-4 hidden">
                    <img id="preview" class="w-full h-64 object-cover rounded-lg">
                </div>
            </div>

            <!-- Ingredients -->
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">
                    Bahan-Bahan <span class="text-red-500">*</span>
                </label>
                <div id="ingredients-container">
                    @foreach(old('ingredients', $recipe->ingredients) as $index => $ingredient)
                        <div class="ingredient-item mb-3 flex gap-2">
                            <input type="text" 
                                name="ingredients[]" 
                                value="{{ $ingredient }}"
                                class="input flex-1"
                                placeholder="Contoh: 2 porsi nasi putih"
                                required>
                            @if($index > 0)
                                <button type="button" 
                                        onclick="removeItem(this)" 
                                        class="btn btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            @endif
                        </div>
                    @endforeach
                </div>
                <button type="button" 
                        onclick="addIngredient()"
                        class="mt-2 text-blue-500 hover:text-blue-600 font-medium">
                    <i class="fas fa-plus-circle mr-1"></i> Tambah Bahan
                </button>
            </div>

            <!-- Steps -->
            <div class="mb-8">
                <label class="block text-gray-700 font-semibold mb-2">
                    Langkah-Langkah <span class="text-red-500">*</span>
                </label>
                <div id="steps-container">
                    @foreach(old('steps', $recipe->steps) as $index => $step)
                        <div class="step-item mb-3 flex gap-2">
                            <textarea name="steps[]" 
                                    rows="3"
                                    class="input flex-1"
                                    placeholder="Langkah {{ $index + 1 }}"
                                    required>{{ $step }}</textarea>
                            @if($index > 0)
                                <button type="button" 
                                        onclick="removeItem(this)" 
                                        class="btn btn-danger self-start">
                                    <i class="fas fa-trash"></i>
                                </button>
                            @endif
                        </div>
                    @endforeach
                </div>
                <button type="button" 
                        onclick="addStep()"
                        class="mt-2 text-blue-500 hover:text-blue-600 font-medium">
                    <i class="fas fa-plus-circle mr-1"></i> Tambah Langkah
                </button>
            </div>

            <!-- Submit Button -->
            <div class="flex gap-4">
                <button type="submit" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold transition">
                    <i class="fas fa-save mr-2"></i> Simpan Perubahan
                </button>
                @if(isset($fromAdmin) && $fromAdmin)
                    @if(url()->previous() && !str_contains(url()->previous(), '/edit') && str_contains(url()->previous(), 'recipes/'))
                        <a href="{{ url()->previous() }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-semibold transition text-center">
                            Batal
                        </a>
                    @else
                        <a href="{{ route('admin.recipes') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-semibold transition text-center">
                            Batal
                        </a>
                    @endif
                @else
                    @if(url()->previous() && !str_contains(url()->previous(), '/edit'))
                        <a href="{{ url()->previous() }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-semibold transition text-center">
                            Batal
                        </a>
                    @else
                        <a href="{{ route('profile') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-semibold transition text-center">
                            Batal
                        </a>
                    @endif
                @endif
            </div>
        </form>
    </div>
</div>
@endsection