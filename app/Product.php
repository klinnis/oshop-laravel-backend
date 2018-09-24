<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title',
        'price',
        'category_id',
        'imageUrl',
    ];

    public function category() {

        return $this->belongsTo('App\Category');
    }

    public $timestamps = false;
}
