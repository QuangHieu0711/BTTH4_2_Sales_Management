<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders'; 

    public $timestamps = false;

    protected $fillable = [
        'customer_id','order_date','status'
    ];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class); // Mỗi đơn hàng thuộc về một khách hàng
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_details'); // Mối quan hệ nhiều-nhiều 
    }
}
