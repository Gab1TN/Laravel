<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BienImmo;
use App\Models\PhotoBien;

class BienImmoController extends Controller
{
    public function index()
    {
        // Récupérer toutes les annonces de la table bien_immo
        $annonces = BienImmo::all();

        // Passer les données à la vue
        return view('annonces.show', compact('annonces'));
    }

    public function show($id)
    {
        $annonce = BienImmo::with('photos')->findOrFail($id);
        return view('partials.annonce_detail', compact('annonce'));
    }

    public function store(Request $request)
    {
        // Validation des données du formulaire
        $validatedData = $request->validate([
            'libelle' => 'required|string|max:255',
            'localisation' => 'required|string|max:255',
            'm2' => 'required|numeric',
            'type' => 'required|string|max:255',
            'etat' => 'required|string|max:255',
            'prix' => 'required|numeric',
            'nb_chambres' => 'required|integer',
            'nb_salles_bain' => 'required|integer',
            'parking' => 'required|string|max:3',
            'garage' => 'required|string|max:3',
            'terrain' => 'required|string|max:3',
            'adresse' => 'required|string|max:255',
            'ville' => 'required|string|max:255',
            'code_postal' => 'required|integer',
            'photo_url' => 'nullable|url'
        ]);

        // Créer un nouveau bien immobilier
        $bien = BienImmo::create($validatedData);

        // Si une URL de photo a été fournie, ajouter l'entrée dans la table photo_bien
        if ($request->has('photo_url') && !empty($request->photo_url)) {
            PhotoBien::create([
                'id_bien' => $bien->id,
                'photo' => $request->photo_url
            ]);
        }

        // Rediriger vers une page de confirmation ou la liste des biens
        return redirect()->route('annonces.index')->with('success', 'Bien immobilier ajouté avec succès!');
    }
}
