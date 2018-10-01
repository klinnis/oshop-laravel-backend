<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShoppingCart extends Model
{
    protected $fillable = ['created_at', 'updated_at' ];

    public function items() {
        return $this->hasMany('App\Item');
    }

    public $timestamps = false;
}
