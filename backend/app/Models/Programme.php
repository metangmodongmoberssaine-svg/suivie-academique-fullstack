<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programme extends Model
{
    use HasFactory;

    protected $table = 'programmes'; // nom exact de la table

    protected $fillable = [
        'code_ec',
        'salle_id',
        'heure_fin',
        'heure_debut',
        'code_personnel',
        'nombre_dheure',
        'statut',
        'date',
    ];

    protected $casts = [
        'date' => 'date',
        'heure_debut' => 'datetime:H:i',
        'heure_fin' => 'datetime:H:i',
    ];

    // Relations
    public function ec()
    {
        return $this->belongsTo(Ec::class, 'code_ec', 'code_ec');
    }

    public function salle()
    {
        return $this->belongsTo(Salle::class, 'salle_id', 'id');
    }
}
