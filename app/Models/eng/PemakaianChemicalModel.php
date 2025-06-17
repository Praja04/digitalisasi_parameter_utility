<?php

namespace App\Models\eng;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class PemakaianChemicalModel extends Model
{
    //
    use HasFactory;

    protected $table = 'pemakaian_chemical';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = ['tanggal','chemical_area','jenis_pemakaian', 'nilai_pemakaian', 'operator', 'updated_at', 'created_at', 'notes','shift'];


}
