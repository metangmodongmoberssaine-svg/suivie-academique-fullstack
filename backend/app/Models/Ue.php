<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ue extends Model
{
    use HasFactory;

    protected $table = 'ues'; // nom exact de la table

    protected $primaryKey = 'code_ue'; // clé primaire personnalisée
    public $incrementing = false; // car ce n’est pas un entier auto-incrémenté
    protected $keyType = 'string'; // car c’est une chaîne (ex: "UE001")

    protected $fillable = [
        'code_ue',
        'label_ue',
        'description_ue',
        'code_niveau',
    ];

    // Si tu veux ajouter une relation avec le modèle Niveau :
    public function niveau()
    {
        return $this->belongsTo(Niveau::class, 'code_niveau', 'code_niveau');
    }
}


