<?php

namespace App\Models\eng;

use Illuminate\Database\Eloquent\Model;

class AirArea extends Model
{
    //
    protected $table = 'air_area_utility';
    protected $primaryKey = 'id';
    protected $fillable = ['nama_area'];

    public function types()
    {
        return $this->hasMany(ChemicalType::class);
    }
}
