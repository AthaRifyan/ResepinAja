@extends('layouts.app')

@section('title', 'Kelola Resep User - ResepinAja')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">
            <i class="fas fa-utensils text-orange-500 mr-2"></i>
            Kelola Resep User
        </h1>
        <p class="text-gray-600 mt-2">Kelola semua resep yang diupload oleh user</p>
    </div>

    <!-- Stats Card -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 bg-orange-100 rounded-full">
                    <i class="fas fa-utensils text-orange-500 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-gray-600 text-sm">Total Resep</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $recipes->total() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recipes Table -->
    <div class="card">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-orange-500 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                            Resep
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                            Pembuat
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                            Tanggal Upload
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recipes as $recipe)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <img src="{{ $recipe->image_url }}" 
                                        alt="{{ $recipe->title }}" 
                                        class="w-16 h-16 rounded-lg object-cover mr-4 shadow-sm">
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $recipe->title }}</div>
                                        <div class="text-sm text-gray-500 mt-1">
                                            <i class="fas fa-clock mr-1"></i>
                                            {{ $recipe->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <img src="{{ $recipe->user->photo_url }}" 
                                        alt="{{ $recipe->user->name }}" 
                                        class="w-10 h-10 rounded-full mr-3 border-2 border-gray-200">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $recipe->user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $recipe->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    {{ $recipe->created_at->format('d M Y') }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $recipe->created_at->format('H:i') }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('recipes.show', ['recipe' => $recipe, 'from' => 'admin.recipes']) }}" 
                                        class="btn btn-secondary text-sm px-3 py-1">
                                        <i class="fas fa-eye mr-1"></i> Lihat
                                    </a>

                                    <!-- Edit Recipe Button -->
                                    <a href="{{ route('recipes.edit', ['recipe' => $recipe, 'from' => 'admin.recipes']) }}" 
                                        class="btn bg-blue-500 hover:bg-blue-600 text-white text-sm px-3 py-1">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </a>

                                    <!-- Delete Recipe Button -->
                                    <button 
                                        type="button" 
                                        class="btn btn-danger text-sm px-3 py-1 btn-delete-recipe"
                                        data-recipe-id="{{ $recipe->id }}"
                                        data-recipe-title="{{ $recipe->title }}"
                                        title="Hapus Resep">
                                        <i class="fas fa-trash mr-1"></i> Hapus
                                    </button>

                                    <form id="delete-form-{{ $recipe->id }}" method="POST" action="{{ route('admin.recipes.delete', $recipe) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <i class="fas fa-inbox text-gray-300 text-5xl mb-4"></i>
                                <p class="text-gray-500 text-lg">Belum ada resep yang diupload</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($recipes->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $recipes->links() }}
            </div>
        @endif
    </div>
</div>
@endsection