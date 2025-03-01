<?php

namespace App\Models\Dissolver;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class DissolverModel extends Model
{
    use HasFactory;

    protected $table = 'dissolver1';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];

    protected $fillable = [
        'Batch', 'Varian', 'PO_Masak', 'No_Formulasi', 'Status_GGA', 'Gula',
        'NaCl_GGA', 'Brix_GGA', 'Warna_GGA', 'Organo_GGA', 'Status_GGAS',
        'NaCl_GGAS', 'Brix_GGAS', 'Warna_GGAS', 'Organo_GGAS', 'created_at'
    ];

   

    public static function getLatestData($limit = 10)
    {
        return self::orderBy('created_at', 'desc')->limit($limit)->get();
    }
}

class Dissolver2 extends DissolverModel
{
    protected $table = 'dissolver2';
}

class Dissolver3 extends DissolverModel
{
    protected $table = 'dissolver3';
}

class Dissolver4 extends DissolverModel
{
    protected $table = 'dissolver4';
}

class Dissolver5 extends DissolverModel
{
    protected $table = 'dissolver5';
}

class Dissolver6 extends DissolverModel
{
    protected $table = 'dissolver6';
}

class Dissolver7 extends DissolverModel
{
    protected $table = 'dissolver7';
}

class Dissolver8 extends DissolverModel
{
    protected $table = 'dissolver8';
}