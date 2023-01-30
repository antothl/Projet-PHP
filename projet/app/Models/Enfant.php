<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enfant extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'prenom',
        'birth',
        'user_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function activite() {
        return $this->belongsToMany(Activite::class);
    }
}
