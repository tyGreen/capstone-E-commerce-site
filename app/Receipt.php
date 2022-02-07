<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Receipt extends Model
{
    use SoftDeletes;

    public $table = 'items_sold';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];

    public function items()
    {
        return $this->hasMany('\App\Item','item_id', 'item_id')->orderBy('name','ASC');
    }
}
