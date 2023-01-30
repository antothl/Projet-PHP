<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActiviteEnfant extends Model
{
    use HasFactory;

    protected $fillable = [
        'enfant_id',
        'activite_id'
      ];
}
