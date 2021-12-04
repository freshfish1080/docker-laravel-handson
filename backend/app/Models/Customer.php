<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    
    // テーブル名
    protected $table = 'customers';

    // 可変項目
    protected $fillable = 
    [
        'customer_code',
        'name',
        'address',
        'phone',
        'email',
        'discount'
    ];

}
