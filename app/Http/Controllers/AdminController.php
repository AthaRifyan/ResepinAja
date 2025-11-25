<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Recipe; // Tambahkan model Recipe
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Display list of users.
     */
    public function users()
    {
        // Only admin can access
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $users = User::where('role', 'user')
                    ->withCount('recipes')
                    ->latest()
                    ->paginate(12);

        return view('admin.users', compact('users'));
    }

    /**
     * Show form to edit user.
     */
    public function editUser(User $user)
    {
        // Only admin can access
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        // Admin cannot edit other admins
        if ($user->isAdmin()) {
            return back()->with('error', 'Tidak dapat mengedit akun admin.');
        }

        return view('admin.edit-user', compact('user'));
    }

    /**
     * Update user.
     */
    public function updateUser(Request $request, User $user)
    {
        // Only admin can access
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        // Admin cannot edit other admins
        if ($user->isAdmin()) {
            return back()->with('error', 'Tidak dapat mengedit akun admin.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'new_password' => 'nullable|min:8',
        ]);

        $user->name = $validated['name'];

        // Update photo if provided
        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $user->photo = $request->file('photo')->store('profiles', 'public');
        }

        // Update password if provided
        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return redirect()->route('admin.users')->with('success', 'User berhasil diperbarui!');
    }

    /**
     * Delete user.
     */
    public function deleteUser(User $user)
    {
        // Only admin can access
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        // Admin cannot delete other admins
        if ($user->isAdmin()) {
            return back()->with('error', 'Tidak dapat menghapus akun admin.');
        }

        // Delete user photo
        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }

        // Delete user (recipes will be cascade deleted if configured in model)
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User berhasil dihapus!');
    }

    /**
     * Display list of all recipes.
     */
    public function recipes()
    {
        // Only admin can access
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $recipes = Recipe::with('user')
                    ->latest()
                    ->paginate(20);

        return view('admin.recipes', compact('recipes'));
    }

    /**
     * Delete a specific recipe.
     */
    public function deleteRecipe(Recipe $recipe)
    {
        // Only admin can access
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        try {
            // Delete image if exists (using Storage facade for public disk)
            if ($recipe->image) {
                Storage::disk('public')->delete($recipe->image);
            }

            $recipe->delete();

            return redirect()
                ->route('admin.recipes')
                ->with('success', 'Resep berhasil dihapus!');
        } catch (\Exception $e) {
            \Log::error('Admin Recipe Deletion Error: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus resep: ' . $e->getMessage());
        }
    }
}