<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssociationUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'association_id',
        'user_id'
    ];
}
