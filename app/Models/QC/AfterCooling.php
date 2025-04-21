<?php

namespace App\Models\QC;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AfterCooling extends Model
{
    //
    use HasFactory;

    protected $table = 'after_cooling';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = ['tanggal', 'created_by_user', 'created_at', 'updated_at','status','batch'];

    // Relasi ke Detail Batch (Shift)
    public function details()
    {
        return $this->hasMany(AfterCoolingDetail::class, 'id_after_cooling');
    }
}
