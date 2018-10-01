<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{

    protected $fillable = ['shoppingcart_id', 'product_id', 'quantity'];

    public function shoppingcart() {
        return $this->belongsTo('App\ShoppingCart');
    }

    public function product() {
        return $this->belongsTo('App\Product');
    }


    public $timestamps = false;
}
