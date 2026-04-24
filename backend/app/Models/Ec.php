<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Ec extends Model
{
    use HasFactory;

    protected $table = 'ecs';
    protected $primaryKey = 'code_ec';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'code_ec',
        'label_ec',
        'description_ec',
        'nb_heures_ec',
        'cours',
        'nb_credit_ec',
        'code_ue',
        'pdf_path', // chemin interne stocké en DB
    ];

    protected $appends = ['pdf_url']; // champ calculé

    public function getPdfUrlAttribute(): ?string
    {
        return $this->pdf_path ? Storage::url($this->pdf_path) : null;
    }
}
