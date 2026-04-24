<?php

namespace App\Exports;

use App\Models\Filiere;
use Maatwebsite\Excel\Concerns\FromCollection;

class FilieresExport implements FromCollection
{
    public function collection()
    {
        return Filiere::all();
    }
}
