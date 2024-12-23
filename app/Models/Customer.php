<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    // Định nghĩa mối quan hệ một-nhiều với bảng orders
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}