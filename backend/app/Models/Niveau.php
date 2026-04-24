<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Niveau extends Model
{
    use HasFactory;

    protected $table = 'niveaux'; // align with migration
    protected $primaryKey = 'code_niveau';
    public $incrementing = false; // ✅ car clé primaire non numérique
    protected $keyType = 'string'; // ✅ car clé primaire est une chaîne

    protected $fillable = [
        'code_niveau',
        'label_niveau',
        'description_niveau',
        'code_filiere',
    ];
}
