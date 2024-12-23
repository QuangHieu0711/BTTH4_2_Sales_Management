<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Customer extends Model
{
    use HasFactory;

    // Tắt tính năng timestamps
    public $timestamps = false;

    // Khai báo tên bảng tương ứng trong cơ sở dữ liệu
    protected $table = 'customers';

    // Khai báo các thuộc tính có thể gán giá trị hàng loạt
    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        
    ];

    // Mối quan hệ nhiều-nhiều với bảng products
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'customer_product', 'customer_id', 'product_id');
    }
}