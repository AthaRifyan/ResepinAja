<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Toggle favorite status for a recipe.
     */
    public function toggle(Request $request, Recipe $recipe)
    {
        $user = Auth::user();

        // Cek apakah user sudah memiliki resep ini di favorit
        $isFavorited = $user->favorites()->where('recipe_id', $recipe->id)->exists();

        if ($isFavorited) {
            // Jika sudah ada, hapus dari favorit menggunakan detach
            $user->favorites()->detach($recipe->id);
            return response()->json([
                'status' => 'removed',
                'message' => 'Resep dihapus dari favorit'
            ]);
        } else {
            // Jika belum ada, tambahkan ke favorit menggunakan attach
            $user->favorites()->attach($recipe->id);
            return response()->json([
                'status' => 'added',
                'message' => 'Resep ditambahkan ke favorit'
            ]);
        }
    }

    /**
     * Show user's favorite recipes.
     */
    public function index()
    {
        $user = Auth::user();
        $recipes = $user->favorites()->latest()->paginate(12);

        return view('recipe-favorite', compact('recipes'));
    }
}