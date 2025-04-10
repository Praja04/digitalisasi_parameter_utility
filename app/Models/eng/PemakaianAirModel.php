<?php

namespace App\Models\eng;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PemakaianAirModel extends Model
{
    //
    use HasFactory;

    protected $table = 'pemakaian_air_eng';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = ['tanggal','pemakaian_liter','created_by','updated_at','created_at','notes'];


}
