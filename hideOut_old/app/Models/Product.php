<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;


    // protected $fillable = [
    //     'name',
    //     'description',
    //     'price',
    //     'image_path',
    // ];
    protected $fillable = ['name', 'description', 'price', 'category', 'quantity', 'image_path'];

    public function cartItems()
{
    return $this->hasMany(CartItem::class);
}

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

}
