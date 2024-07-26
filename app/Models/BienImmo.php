<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BienImmo extends Model
{
    use HasFactory;

    protected $table = 'bien_immo';

    protected $fillable = [
        'libelle', 'prix', 'etat', 'adresse', 'ville', 'code_postal', 'localisation', 'm2', 'type', 'nb_chambres', 'nb_salles_bain', 'parking', 'garage', 'terrain', 'photo_url'
    ];

    public function photos()
    {
        return $this->hasMany(PhotoBien::class, 'id_bien');
    }

    public function utilisateursFavoris()
    {
        return $this->belongsToMany(User::class, 'favoris', 'bien_immo_id', 'user_id')->withTimestamps();
    }
}
