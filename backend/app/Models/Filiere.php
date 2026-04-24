<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Filiere extends Model
{
    use HasFactory;
    protected $table = 'filieres';
    protected $primaryKey = 'code_filiere';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'code_filiere',
        'label_filiere',
        'description_filiere'
    ];

    // Relations
    public function niveaux()
    {
        return $this->hasMany(Niveau::class, 'code_filiere', 'code_filiere');
    }


}
