<?php

namespace App\Models\eng;

use Illuminate\Database\Eloquent\Model;

class ChemicalType extends Model
{
    //
    protected $table = 'chemical_types';
    protected $primaryKey = 'id';
    protected $fillable = ['chemical_area_id', 'nama_chemical','satuan'];

    public function area()
    {
        return $this->belongsTo(ChemicalArea::class, 'chemical_area_id');
    }
}
