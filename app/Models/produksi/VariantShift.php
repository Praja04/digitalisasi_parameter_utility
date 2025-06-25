<?php

namespace App\Models\produksi;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VariantShift extends Model
{
    use HasFactory;

    protected $table = 'variant_shifts';
    protected $fillable = ['variant_name', 'shift_number','total', 'tanggal'];

    public $timestamps = false;

    public function target()
    {
        return $this->belongsTo(VariantTarget::class, 'variant_name', 'variant_name')
            ->whereColumn('variant_shifts.tanggal', 'variant_targets.tanggal');
    }
}