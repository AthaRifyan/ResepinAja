@extends('layouts.app')

@section('title', 'Edit User - ResepinAja')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="card p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 flex items-center">
            <i class="fas fa-user-edit text-blue-500 mr-3"></i>
            Edit User
        </h1>

        <form method="POST" action="{{ route('admin.users.update', $user) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Current Photo -->
            <div class="mb-6 text-center">
                <img src="{{ $user->photo_url }}" 
                    alt="{{ $user->name }}" 
                    id="current-photo"
                    class="avatar avatar-lg mx-auto border-4 border-blue-500 mb-4">
            </div>

            <!-- Name -->
            <div class="mb-6">
                <label for="name" class="block text-gray-700 font-semibold mb-2">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name', $user->name) }}"
                    class="input @error('name') input-error @enderror"
                    required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email (Read Only) -->
            <div class="mb-6">
                <label for="email" class="block text-gray-700 font-semibold mb-2">
                    Email
                </label>
                <input type="email" 
                    id="email" 
                    value="{{ $user->email }}"
                    class="input bg-gray-100 cursor-not-allowed"
                    disabled
                    readonly>
                <p class="text-sm text-gray-500 mt-1">
                    <i class="fas fa-info-circle mr-1"></i> Email tidak dapat diubah.
                </p>
            </div>

            <!-- Photo -->
            <div class="mb-6">
                <label for="photo" class="block text-gray-700 font-semibold mb-2">
                    Foto Profil
                </label>
                <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-4 hover:border-blue-500 transition">
                    <input type="file" 
                        id="photo" 
                        name="photo" 
                        accept="image/*"
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                        onchange="previewPhoto(this)">
                    <div class="text-center">
                        <i class="fas fa-camera text-gray-400 text-2xl mb-1"></i>
                        <p class="text-sm text-gray-600">Upload foto profil baru (opsional)</p>
                    </div>
                </div>
                <div id="photo-preview" class="mt-3 hidden text-center">
                    <img id="preview" class="avatar avatar-lg mx-auto border-4 border-blue-500">
                </div>
                @error('photo')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- New Password -->
            <div class="mb-6">
                <label for="new_password" class="block text-gray-700 font-semibold mb-2">
                    Password Baru (Opsional)
                </label>
                <input type="password" 
                    id="new_password" 
                    name="new_password" 
                    class="input @error('new_password') input-error @enderror"
                    placeholder="Masukkan password baru jika ingin mengubah">
                <p class="text-sm text-gray-500 mt-1">
                    Kosongkan jika tidak ingin mengubah password
                </p>
                @error('new_password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div class="flex gap-4">
                <button type="submit" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold transition">
                    <i class="fas fa-save mr-2"></i> Simpan Perubahan
                </button>
                <a href="{{ route('admin.users') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-semibold transition text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection