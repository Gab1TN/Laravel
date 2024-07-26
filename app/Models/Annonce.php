<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Annonce extends Model
{
    // Nom de la table dans votre base de données
    protected $table = 'bien_immo';

    // Les champs qui peuvent être assignés en masse
    protected $fillable = [
        'libelle', 
        'nom', 
        'prenom', 
        'localisation', 
        'm2', 
        'type', 
        'etat', 
        'nb_chambres', 
        'nb_salles_bain', 
        'parking', 
        'garage', 
        'terrain', 
        'prix', 
        'adresse', 
        'ville', 
        'code_postal'
    ];

    // Relation avec les photos de l'annonce
    public function photos()
    {
        return $this->hasMany(PhotoBien::class, 'id_bien', 'id');
    }
}
