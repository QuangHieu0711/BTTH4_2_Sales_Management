<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'description', 'price', 'quantity'];
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_details')->withPivot('quantity');
    }
}
