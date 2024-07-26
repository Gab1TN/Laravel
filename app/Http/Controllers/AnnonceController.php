<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Annonce;

class AnnonceController extends Controller
{
    // Afficher le formulaire pour déposer un bien
    public function create()
    {
        return view('deposerbien.deposer_bien'); // Assurez-vous que ce chemin est correct
    }

    // Stocker le bien dans la base de données
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'libelle' => 'required|string|max:255',
            'localisation' => 'required|string|max:255',
            'm2' => 'required|numeric|min:0',
            'type' => 'required|string|in:Appartement,Maison,Terrain,Commerce',
            'etat' => 'required|string|in:neuf,renové,plateau',
            'nb_chambres' => 'required|integer|min:0',
            'nb_salles_bain' => 'required|integer|min:0',
            'parking' => 'required|in:oui,non',
            'garage' => 'required|in:oui,non',
            'terrain' => 'required|in:oui,non',
            'prix' => 'required|numeric|min:0',
            'photo_url' => 'nullable|url|max:255',
        ]);

        $annonce = Annonce::create($validatedData);

        return redirect()->route('annonce.show', $annonce->id)->with('success', 'Annonce déposée avec succès !');
    }

    // Afficher une annonce spécifique
    public function show($id)
    {
        $annonce = Annonce::findOrFail($id);
        return view('annonces.show', compact('annonce'));
    }

    // Rechercher des annonces
    public function search(Request $request)
    {
        $query = $request->input('query');
        $minPrix = $request->input('min_prix');
        $maxPrix = $request->input('max_prix');
        $etat = $request->input('etat');
        $minChambres = $request->input('min_chambres');
        $maxChambres = $request->input('max_chambres');
        $ville = $request->input('ville');

        $annonces = Annonce::query()
            ->when($query, function($q, $query) {
                return $q->where('libelle', 'like', '%' . $query . '%')
                         ->orWhere('ville', 'like', '%' . $query . '%');
            })
            ->when($minPrix, function($q, $minPrix) {
                return $q->where('prix', '>=', $minPrix);
            })
            ->when($maxPrix, function($q, $maxPrix) {
                return $q->where('prix', '<=', $maxPrix);
            })
            ->when($etat, function($q, $etat) {
                return $q->where('etat', $etat);
            })
            ->when($minChambres, function($q, $minChambres) {
                return $q->where('nb_chambres', '>=', $minChambres);
            })
            ->when($maxChambres, function($q, $maxChambres) {
                return $q->where('nb_chambres', '<=', $maxChambres);
            })
            ->when($ville, function($q, $ville) {
                return $q->where('ville', 'like', '%' . $ville . '%');
            })
            ->get();

        return view('annonces.search', ['annonces' => $annonces]);
    }
}
