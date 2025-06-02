<?php

namespace App\Models\Warehouse;

use Illuminate\Database\Eloquent\Model;

class CheckItem extends Model
{
    //
    protected $table = 'check_items';
    protected $fillable = ['name', 'normal_condition', 'weight'];

    public function checkFormItems()
    {
        return $this->hasMany(CheckFormItem::class);
    }
}
