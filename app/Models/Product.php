<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'season_id',
        'name',
        'slug',
        'images',
        'description',
        'price',
        'is_active',
        'is_featured',
        'in_stock',
        'on_sale',
    ];

    protected $casts = [
        'images'=> 'array',
    ];
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function season(){
        return $this->belongsTo(Season::class);
    }
    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }
}
