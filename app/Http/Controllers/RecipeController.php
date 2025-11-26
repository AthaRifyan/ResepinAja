<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class RecipeController extends Controller
{
    /**
     * Display a listing of recipes.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        
        $query = Recipe::with('user')->latest();
        
        // Apply search filter if search term exists
        if ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        }
        
        $recipes = $query->paginate(12);
        
        return view('home', compact('recipes', 'search'));
    }

    /**
     * Show the form for creating a new recipe.
     */
    public function create()
    {
        return view('recipe-upload');
    }

    /**
     * Store a newly created recipe.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'ingredients' => 'required|array|min:1',
            'ingredients.*' => 'required|string',
            'steps' => 'required|array|min:1',
            'steps.*' => 'required|string',
        ]);

        $imagePath = $request->file('image')->store('recipes', 'public');

        Recipe::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'image' => $imagePath,
            'ingredients' => array_values(array_filter($validated['ingredients'])),
            'steps' => array_values(array_filter($validated['steps'])),
        ]);

        return redirect()->route('home')->with('success', 'Resep berhasil ditambahkan!');
    }

    /**
     * Display the specified recipe.
     */
    public function show(Recipe $recipe, Request $request)
    {
        $recipe->load('user');

        $fromAdmin = $request->query('from') === 'admin.recipes';
        $fromProfile = $request->query('from') === 'profile' || 
                    (!$fromAdmin && url()->previous() === route('profile')); 
        $fromFavorite = $request->query('from') === 'favorite';

        // Kirim variabel ke view
        return view('recipe-detail', compact('recipe', 'fromProfile', 'fromAdmin', 'fromFavorite'));
    }

    /**
     * Show the form for editing the recipe.
     */
    public function edit(Recipe $recipe, Request $request)
    {
        // Check auth resep tersebut milik user atau admin
        if ($recipe->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        // Deteksi dari mana user datang
        $fromAdmin = $request->query('from') === 'admin.recipes';
        $fromProfile = $request->query('from') === 'profile';

        return view('recipe-edit', compact('recipe', 'fromAdmin', 'fromProfile'));
    }

    /**
     * Update the specified recipe.
     */
    public function update(Request $request, Recipe $recipe)
    {
        // Check auth resep tersebut milik user atau admin
        if ($recipe->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'ingredients' => 'required|array|min:1',
            'ingredients.*' => 'required|string',
            'steps' => 'required|array|min:1',
            'steps.*' => 'required|string',
        ]);

        // Update foto jika ada file baru
        if ($request->hasFile('image')) {
            // Delete foto lama
            if ($recipe->image) {
                Storage::disk('public')->delete($recipe->image);
            }
            $recipe->image = $request->file('image')->store('recipes', 'public');
        }

        $recipe->title = $validated['title'];
        $recipe->ingredients = array_values(array_filter($validated['ingredients']));
        $recipe->steps = array_values(array_filter($validated['steps']));
        $recipe->save();
        
        if ($request->query('from') === 'admin.recipes') {
            // Dari admin → redirect ke detail resep dengan context admin
            return redirect()->route('recipes.show', ['recipe' => $recipe, 'from' => 'admin.recipes'])
                ->with('success', 'Resep berhasil diperbarui!');
        } elseif ($request->query('from') === 'profile') {
            // Dari profile → redirect ke detail resep dengan context profile
            return redirect()->route('recipes.show', ['recipe' => $recipe, 'from' => 'profile'])
                ->with('success', 'Resep berhasil diperbarui!');
        }

        // Default: redirect ke detail resep (dari home/search/dll)
        return redirect()->route('recipes.show', $recipe)
            ->with('success', 'Resep berhasil diperbarui!');
    }

    /**
     * Remove the specified recipe.
     */
    public function destroy(Recipe $recipe)
    {
        // Check auth resep tersebut milik user atau admin
        if ($recipe->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        // Delete file foto resep
        if ($recipe->image) {
            Storage::disk('public')->delete($recipe->image);
        }

        $recipe->delete();

        return redirect()->route('profile')->with('success', 'Resep berhasil dihapus!');
    }

    /**
     * Download recipe as PDF.
     */
    public function downloadPdf(Recipe $recipe)
    {
        $recipe->load('user');
        
        $pdf = Pdf::loadView('recipe-pdf', compact('recipe'));
        
        // Generate nama file dari nama resep
        $filename = str_replace(' ', '-', strtolower($recipe->title)) . '.pdf';
        
        return $pdf->download($filename);
    }
}