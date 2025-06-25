<?php

namespace App\Models\produksi;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VariantTarget extends Model
{
    //
    use HasFactory;

    protected $table = 'variant_targets';
    protected $fillable = ['variant_name', 'target', 'tanggal'];

    public $timestamps = false;

    public function shifts()
    {
        return $this->hasOne(VariantShift::class, 'variant_name', 'variant_name')
            ->whereColumn('variant_shifts.tanggal', 'variant_targets.tanggal');
    }

}
