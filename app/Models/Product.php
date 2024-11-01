<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'price', 'stock', 'weight', 'category_id', 'quantity'
    ];

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function carts()
    {
        return $this->belongsToMany(Cart::class, 'cartproducts')->withPivot('quantity');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'orderproducts')->withPivot('quantity');
    }

    public static function bestSellers($limit = 4)
    {
        return self::leftJoin('orderproducts', 'products.id', '=', 'orderproducts.product_id')
            ->select('products.*', \DB::raw('COALESCE(SUM(orderproducts.quantity), 0) as total_sales'))
            ->groupBy('products.id')
            ->orderByDesc('total_sales')
            ->limit($limit)
            ->get();
    }
}
