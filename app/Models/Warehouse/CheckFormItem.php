<?php

namespace App\Models\Warehouse;

use Illuminate\Database\Eloquent\Model;

class CheckFormItem extends Model
{
    //
    protected $table = 'check_form_items';
    protected $fillable = ['check_form_id', 'check_item_id', 'condition_value', 'remarks'];

    public function checkForm()
    {
        return $this->belongsTo(CheckForm::class);
    }

    public function checkItem()
    {
        return $this->belongsTo(CheckItem::class);
    }
}
