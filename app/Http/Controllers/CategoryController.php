<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Colocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Afficher la liste des catégories d'une colocation
     */
    public function index(Colocation $colocation)
    {
        // Vérifier que l'utilisateur est membre
        if (!$colocation->hasActiveMember(Auth::user())) {
            return redirect()->route('colocations.index')
                ->with('error', 'Vous n\'êtes pas membre de cette colocation.');
        }

        $categories = Category::forColocation($colocation->id)
            ->with(['creator', 'expenses'])
            ->get();

        return view('categories.index', compact('colocation', 'categories'));
    }

    /**
     * Formulaire de création
     */
    public function create(Colocation $colocation)
    {
        if (!$colocation->hasActiveMember(Auth::user())) {
            return redirect()->route('colocations.index')
                ->with('error', 'Vous n\'êtes pas membre de cette colocation.');
        }

        return view('categories.create', compact('colocation'));
    }

    /**
     * Enregistrer une nouvelle catégorie
     */
    public function store(Request $request, Colocation $colocation)
    {
        if (!$colocation->hasActiveMember(Auth::user())) {
            return redirect()->route('colocations.index')
                ->with('error', 'Vous n\'êtes pas membre de cette colocation.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:7',
        ]);

        // Vérifier si la catégorie existe déjà
        $existing = Category::forColocation($colocation->id)
            ->where('name', $request->name)
            ->first();

        if ($existing) {
            return redirect()->back()
                ->with('error', 'Une catégorie avec ce nom existe déjà.')
                ->withInput();
        }

        Category::create([
            'name' => $request->name,
            'color' => $request->color,
            'colocation_id' => $colocation->id,
            'created_by' => Auth::id(),
            'is_default' => false
        ]);

        return redirect()->route('colocations.show', $colocation)
            ->with('success', 'Catégorie ajoutée avec succès !');
    }

    /**
     * Modifier une catégorie
     */
    public function edit(Colocation $colocation, Category $category)
    {
        if (!$colocation->hasActiveMember(Auth::user())) {
            return redirect()->route('colocations.index')
                ->with('error', 'Vous n\'êtes pas membre de cette colocation.');
        }

        // Vérifier que la catégorie appartient à cette colocation
        if ($category->colocation_id != $colocation->id) {
            abort(404);
        }

        return view('categories.edit', compact('colocation', 'category'));
    }

    /**
     * Mettre à jour une catégorie
     */
    public function update(Request $request, Colocation $colocation, Category $category)
    {
        if (!$colocation->hasActiveMember(Auth::user())) {
            return redirect()->route('colocations.index')
                ->with('error', 'Vous n\'êtes pas membre de cette colocation.');
        }

        if ($category->colocation_id != $colocation->id) {
            abort(404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:7',
        ]);

        $category->update([
            'name' => $request->name,
            'color' => $request->color
        ]);

        return redirect()->route('colocations.show', $colocation)
            ->with('success', 'Catégorie mise à jour avec succès !');
    }

    /**
     * Supprimer une catégorie
     */
    public function destroy(Colocation $colocation, Category $category)
    {
        if (!$colocation->hasActiveMember(Auth::user())) {
            return redirect()->route('colocations.index')
                ->with('error', 'Vous n\'êtes pas membre de cette colocation.');
        }

        if ($category->colocation_id != $colocation->id) {
            abort(404);
        }

        // Vérifier si des dépenses utilisent cette catégorie
        if ($category->expenses()->count() > 0) {
            return redirect()->route('colocations.show', $colocation)
                ->with('error', 'Impossible de supprimer cette catégorie car elle est utilisée par des dépenses.');
        }

        $category->delete();

        return redirect()->route('colocations.show', $colocation)
            ->with('success', 'Catégorie supprimée avec succès !');
    }
}