<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    // 🔹 Table name (IMPORTANT)
    // Remove this line ONLY if your table name is exactly `products`
    protected $table = 'products';

    // 🔹 Mass assignable fields
    protected $fillable = [
        'title',
        'price',
    ];

    // 🔹 Relationship: Product → Order Items
  public function orderItems()
{
    return $this->hasMany(OrderItem::class);
}

}
