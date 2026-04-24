<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enseigne extends Model
{
    use HasFactory;

    protected $table = 'enseigne'; // cohérent avec ta migration

    protected $fillable = [
        'code_ec',
        'code_personnel',
    ];

    public $timestamps = true;

    public function ec()
    {
        return $this->belongsTo(Ec::class, 'code_ec', 'code_ec');
    }

    public function personnel()
    {
        return $this->belongsTo(Personnel::class, 'code_personnel', 'code_personnel');
    }
}
