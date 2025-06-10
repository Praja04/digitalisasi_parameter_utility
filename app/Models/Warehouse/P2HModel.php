<?php

namespace App\Models\Warehouse;

use Illuminate\Database\Eloquent\Model;

class P2HModel extends Model
{
    //
    protected $table = 'master_p2h';
    protected $primaryKey = 'id';
    protected $fillable = ['tanggal', 'nomor_unit', 'dept','status'];

    public function details()
    {
        return $this->hasMany(detailP2HModel::class, 'id_p2h');
    }
}
