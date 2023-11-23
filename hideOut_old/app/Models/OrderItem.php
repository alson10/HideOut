<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    // protected $fillable = [
    //     'product_name', // Add 'product_name' to the fillable array
    //     'price',
    //     'quantity',
    //     'image_path',
    //     // other fields...
    // ];
    protected $fillable = [
        'product_id',  // Make sure 'product_id' is present in the $fillable array
        'product_name',
        'price',
        'quantity',
        'image_path',
    ];
}
