<?php

namespace App\Models\eng;

use Illuminate\Database\Eloquent\Model;

class ChemicalArea extends Model
{
    //
    protected $table = 'chemical_areas';
    protected $primaryKey = 'id';
    protected $fillable = ['nama_area'];

    public function types()
    {
        return $this->hasMany(ChemicalType::class);
    }
}
