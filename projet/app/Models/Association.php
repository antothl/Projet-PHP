<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Association extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom'
    ];

    public function activite() {
        return $this->hasMany(Activite::class);
    }

    public function user() {
        return $this->belongsToMany(User::class);
    }
}
