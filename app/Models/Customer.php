<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
      // Khai báo tên bảng tương ứng trong cơ sở dữ liệu
      protected $table = 'customers';

      // Khai báo các thuộc tính có thể gán giá trị hàng loạt
      protected $fillable = [
          'name',
          'address',
          'phone',
          'email',
      ];
}
