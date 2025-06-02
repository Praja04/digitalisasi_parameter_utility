<?php

namespace App\Models\Warehouse;

use Illuminate\Database\Eloquent\Model;

class Forklift extends Model
{
    //
    protected $table = 'forklifts';
    protected $fillable = ['name', 'description'];

    public function checkForms()
    {
        return $this->hasMany(CheckForm::class);
    }
}
