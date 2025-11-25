<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecipeController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [RecipeController::class, 'index'])->name('home');

// Authentication Routes (untuk yang belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated Routes (untuk yang sudah login)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Recipe Management - PENTING: routes spesifik harus di ATAS routes dengan parameter
    Route::get('/recipes/create', [RecipeController::class, 'create'])->name('recipes.create');
    Route::post('/recipes', [RecipeController::class, 'store'])->name('recipes.store');
    Route::get('/recipes/{recipe}/edit', [RecipeController::class, 'edit'])->name('recipes.edit');
    Route::put('/recipes/{recipe}', [RecipeController::class, 'update'])->name('recipes.update');
    Route::delete('/recipes/{recipe}', [RecipeController::class, 'destroy'])->name('recipes.destroy');

    // NEW: Favorite Routes
    Route::post('/recipes/{recipe}/favorite', [\App\Http\Controllers\FavoriteController::class, 'toggle'])
        ->name('recipes.favorite');
    Route::get('/profile/favorites', [\App\Http\Controllers\FavoriteController::class, 'index'])
        ->name('profile.favorites');

    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Admin Routes (only for admin)
    Route::middleware('admin')->group(function () {
        Route::get('/admin/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('admin.users');
        Route::get('/admin/users/{user}/edit', [\App\Http\Controllers\AdminController::class, 'editUser'])->name('admin.users.edit');
        Route::put('/admin/users/{user}', [\App\Http\Controllers\AdminController::class, 'updateUser'])->name('admin.users.update');
        Route::delete('/admin/users/{user}', [\App\Http\Controllers\AdminController::class, 'deleteUser'])->name('admin.users.delete');

        // NEW: Admin Recipes Management
        Route::get('/admin/recipes', [\App\Http\Controllers\AdminController::class, 'recipes'])->name('admin.recipes');
        Route::delete('/admin/recipes/{recipe}', [\App\Http\Controllers\AdminController::class, 'deleteRecipe'])->name('admin.recipes.delete');
    });

    // Rute untuk Chat AI ResepinBot
    Route::get('/chat', [\App\Http\Controllers\ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat/send', [\App\Http\Controllers\ChatController::class, 'send'])->name('chat.send');
    Route::post('/chat/clear', [\App\Http\Controllers\ChatController::class, 'clear'])->name('chat.clear');
});

// Recipe detail route - Letakkan SETELAH /recipes/create untuk menghindari konflik
Route::get('/recipes/{recipe}', [RecipeController::class, 'show'])->name('recipes.show');
Route::get('/recipes/{recipe}/download', [RecipeController::class, 'downloadPdf'])->name('recipes.download');
