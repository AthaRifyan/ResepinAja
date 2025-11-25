@extends('layouts.app')

@section('title', 'Upload Resep - ResepinAja')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="card p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 flex items-center">
            <i class="fas fa-plus-circle text-orange-500 mr-3"></i>
            Upload Resep Baru
        </h1>

        <form method="POST" action="{{ route('recipes.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- Title -->
            <div class="mb-6">
                <label for="title" class="block text-gray-700 font-semibold mb-2">
                    Nama Masakan <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                    id="title" 
                    name="title" 
                    value="{{ old('title') }}"
                    class="input"
                    placeholder="Contoh: Nasi Goreng Spesial"
                    required>
            </div>

            <!-- Image -->
            <div class="mb-6">
                <label for="image" class="block text-gray-700 font-semibold mb-2">
                    Foto Masakan <span class="text-red-500">*</span>
                </label>
                <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-6 hover:border-orange-500 transition">
                    <input type="file" 
                        id="image" 
                        name="image" 
                        accept="image/*"
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                        onchange="previewImage(this)"
                        required>
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
                    <div class="ingredient-item mb-3 flex gap-2">
                        <input type="text" 
                            name="ingredients[]" 
                            class="input flex-1"
                            placeholder="Contoh: 2 porsi nasi putih"
                            required>
                    </div>
                </div>
                <button type="button" 
                        onclick="addIngredient()"
                        class="mt-2 text-orange-500 hover:text-orange-600 font-medium">
                    <i class="fas fa-plus-circle mr-1"></i> Tambah Bahan
                </button>
            </div>

            <!-- Steps -->
            <div class="mb-8">
                <label class="block text-gray-700 font-semibold mb-2">
                    Langkah-Langkah <span class="text-red-500">*</span>
                </label>
                <div id="steps-container">
                    <div class="step-item mb-3">
                        <textarea name="steps[]" 
                                rows="3"
                                class="input"
                                placeholder="Contoh: Panaskan minyak dalam wajan dengan api sedang"
                                required></textarea>
                    </div>
                </div>
                <button type="button" 
                        onclick="addStep()"
                        class="mt-2 text-orange-500 hover:text-orange-600 font-medium">
                    <i class="fas fa-plus-circle mr-1"></i> Tambah Langkah
                </button>
            </div>

            <!-- Submit Button -->
            <div class="flex gap-4">
                <button type="submit" class="btn btn-primary flex-1">
                    <i class="fas fa-save mr-2"></i> Simpan Resep
                </button>
                <a href="{{ route('home') }}" class="btn btn-secondary text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection