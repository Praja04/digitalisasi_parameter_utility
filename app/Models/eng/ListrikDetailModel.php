<?php

namespace App\Models\eng;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ListrikDetailModel extends Model
{
    //
    protected $table = 'pemakaian_listrik_detail';
    protected $primaryKey = 'id';
    protected $fillable = ['id_listrik','panel_type', 'volt', 'a','kw','mwh'];

    public function listrik_detail()
    {
        return $this->belongsTo(PemakaianListrikModel::class, 'id');
    }
}
