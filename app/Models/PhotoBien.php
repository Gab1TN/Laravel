<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoBien extends Model
{
    use HasFactory;

    protected $table = 'photo_bien'; // Nom de la table

    protected $fillable = [
        'id_bien', 'photo'
    ];

    public function bien()
    {
        return $this->belongsTo(BienImmo::class, 'id_bien');
    }
}