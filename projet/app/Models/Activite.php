<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activite extends Model
{
    use HasFactory;
    protected $fillable = [
        'titre',
        'description',
        'dateDebut',
        'dateFin',
        'places',
        'association_id'
    ];

    public function enfants() {
        return $this->belongsToMany(Enfant::class);
    }

    public function association() {
        return $this->belongsTo(Association::class);
    }
}
