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

    protected $fillable = [
        'tanggal',
        'pemakaian_awal',
        'pemakaian_akhir',
        'jenis_pemakaian',
        'created_by',
        'notes'
    ];

}
