@extends('layouts.app')

@section('title', 'Kelola Akun User - ResepinAja')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 flex items-center">
            <i class="fas fa-users-cog text-orange-500 mr-3"></i>
            Kelola Akun User
        </h1>
        <p class="text-gray-600 mt-2">Kelola semua akun pengguna yang terdaftar</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 bg-orange-100 rounded-full">
                    <i class="fas fa-users text-orange-500 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-gray-600 text-sm">Total User</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $users->total() }}</p>
                </div>
            </div>
        </div>
    </div>

    @if($users->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($users as $user)
                <div class="card card-hover p-6 group">
                    <!-- User Photo -->
                    <div class="text-center mb-4">
                        <img src="{{ $user->photo_url }}" 
                            alt="{{ $user->name }}" 
                            class="avatar avatar-lg mx-auto border-4 border-orange-500 transition-transform duration-300 group-hover:scale-110">
                    </div>

                    <!-- User Info -->
                    <div class="text-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-1 group-hover:text-orange-500 transition">{{ $user->name }}</h3>
                        <p class="text-sm text-gray-600 mb-2">{{ $user->email }}</p>
                        
                        <div class="flex justify-center gap-4 text-sm">
                            <div class="bg-orange-50 px-3 py-1 rounded-lg">
                                <span class="font-semibold text-orange-600">{{ $user->recipes_count }}</span>
                                <span class="text-gray-600"> Resep</span>
                            </div>
                            <div class="bg-blue-50 px-3 py-1 rounded-lg">
                                <span class="text-blue-600 text-xs">{{ $user->created_at->format('M Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="grid grid-cols-2 gap-2">
                        <a href="{{ route('admin.users.edit', $user) }}" 
                            class="btn bg-blue-500 hover:bg-blue-600 text-white text-center text-sm">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </a>
                        <form method="POST" 
                            action="{{ route('admin.users.delete', $user) }}" 
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini? Semua resep user akan ikut terhapus!')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-full text-sm">
                                <i class="fas fa-trash mr-1"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $users->links() }}
        </div>
    @else
        <div class="card p-12 text-center">
            <i class="fas fa-users text-gray-300 text-6xl mb-4"></i>
            <p class="text-gray-500 text-lg">Belum ada user terdaftar.</p>
        </div>
    @endif
</div>
@endsection