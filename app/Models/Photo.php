<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $table = 'photo_bien';

    protected $fillable = ['id_bien', 'photo'];

    public function bienImmo()
    {
        return $this->belongsTo(BienImmo::class, 'id_bien');
    }
}
