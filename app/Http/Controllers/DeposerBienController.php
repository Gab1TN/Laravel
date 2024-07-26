<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BienImmo;
use App\Models\PhotoBien;

class DeposerBienController extends Controller
{
    public function index()
    {
        return view('deposerbien.deposer_bien');
    }

    public function store(Request $request)
    {
        $request->validate([
            'libelle' => 'required|string|max:255',
            'prix' => 'required|integer',
            'etat' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'ville' => 'required|string|max:255',
            'code_postal' => 'required|integer',
            'localisation' => 'required|string|max:255',
            'm2' => 'required|numeric',
            'type' => 'required|in:Appartement,Maison,Terrain,Commerce',
            'nb_chambres' => 'required|integer',
            'nb_salles_bain' => 'required|integer',
            'parking' => 'required|in:oui,non',
            'garage' => 'required|in:oui,non',
            'terrain' => 'required|in:oui,non',
            'photo_url' => 'nullable|url'
        ]);

        // Créer un nouvel bien
        $bien = BienImmo::create($request->all());

        // Ajouter la photo si l'URL est fournie
        if ($request->filled('photo_url')) {
            PhotoBien::create([
                'id_bien' => $bien->id,
                'photo' => $request->input('photo_url')
            ]);
        }

        return redirect()->route('deposer_bien')->with('success', 'Bien déposé avec succès !');
    }
}
