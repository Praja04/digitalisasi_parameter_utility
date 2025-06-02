<?php

namespace App\Models\Warehouse;

use Illuminate\Database\Eloquent\Model;

class CheckForm extends Model
{
    //
    protected $table = 'check_forms';
    protected $fillable = ['forklift_id', 'shift', 'tanggal', 'operator_name'];

    public function forklift()
    {
        return $this->belongsTo(Forklift::class);
    }

    public function checkFormItems()
    {
        return $this->hasMany(CheckFormItem::class);
    }
}
