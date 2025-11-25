@extends('layouts.app')

@section('title', 'Daftar - ResepinAja')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-12">
    <div class="max-w-md w-full">
        <!-- Logo & Title -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-orange-500 rounded-full mb-4">
                <i class="fas fa-utensils text-white text-2xl"></i>
            </div>
            <h2 class="text-3xl font-bold text-gray-800">Daftar ResepinAja</h2>
            <p class="text-gray-600 mt-2">Buat akun untuk berbagi resep</p>
        </div>

        <!-- Register Card -->
        <div class="card p-8">
            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                @csrf

                <!-- Name -->
                <div class="mb-5">
                    <label for="name" class="block text-gray-700 font-semibold mb-2">
                        Nama Lengkap
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <input type="text" 
                            id="name" 
                            name="name" 
                            value="{{ old('name') }}"
                            class="input pl-10 @error('name') input-error @enderror"
                            placeholder="John Doe"
                            required 
                            autofocus>
                    </div>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-5">
                    <label for="email" class="block text-gray-700 font-semibold mb-2">
                        Email
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}"
                            class="input pl-10 @error('email') input-error @enderror"
                            placeholder="nama@email.com"
                            required>
                    </div>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Photo -->
                <div class="mb-5">
                    <label for="photo" class="block text-gray-700 font-semibold mb-2">
                        Foto Profil (Opsional)
                    </label>
                    <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-4 hover:border-orange-500 transition">
                        <input type="file" 
                            id="photo" 
                            name="photo" 
                            accept="image/*"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                            onchange="previewPhoto(this)">
                        <div class="text-center">
                            <i class="fas fa-camera text-gray-400 text-2xl mb-1"></i>
                            <p class="text-sm text-gray-600">Upload foto profil</p>
                        </div>
                    </div>
                    <div id="photo-preview" class="mt-3 hidden text-center">
                        <img id="preview" class="avatar avatar-lg mx-auto border-4 border-orange-500">
                    </div>
                    @error('photo')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-5">
                    <label for="password" class="block text-gray-700 font-semibold mb-2">
                        Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input type="password" 
                            id="password" 
                            name="password" 
                            class="input pl-10 @error('password') input-error @enderror"
                            placeholder="••••••••"
                            required>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-gray-700 font-semibold mb-2">
                        Konfirmasi Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input type="password" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            class="input pl-10"
                            placeholder="••••••••"
                            required>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary w-full">
                    <i class="fas fa-user-plus mr-2"></i> Daftar
                </button>

                <!-- Login Link -->
                <p class="text-center text-gray-600 mt-6">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-orange-500 hover:text-orange-600 font-semibold">
                        Masuk sekarang
                    </a>
                </p>
            </form>
        </div>

        <!-- Back to Home -->
        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="text-gray-600 hover:text-orange-500 transition">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsections