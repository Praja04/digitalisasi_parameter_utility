<?php

namespace App\Models\eng;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PemakaianListrikModel extends Model
{
    //
    use HasFactory;

    protected $table = 'pemakaian_listrik_eng';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [ 'waktu', 'operator','status'];

    public function details()
    {
        return $this->hasMany(ListrikDetailModel::class,'id_listrik' );
    }
}
