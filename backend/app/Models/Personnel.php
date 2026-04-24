<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class Personnel extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $table = 'personnel';
    protected $primaryKey = 'code_personnel';
    public $incrementing = false;
    protected $keyType = 'string';             

    protected $fillable = [
        'code_personnel',
        'nom_personnel',
        'sex_personnel',
        'phone_personnel',
        'login_personnel',
        'password_personnel',
        'type_personnel'
    ];
}
