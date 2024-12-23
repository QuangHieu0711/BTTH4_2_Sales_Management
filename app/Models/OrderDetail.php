<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{

    protected $table = 'order_details'; 

    public $timestamps = false;

    protected $fillable = [
        'order_id', 
        'product_id', 
        'quantity',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_details')->withPivot('quantity');
    }
}


