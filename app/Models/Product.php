<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name', 
        'price', 
        'description', 
        'category_id', 
        'image', 
        'image_2', 
        'image_3', 
        'image_4', 
        'specifications', 
        'is_in_stock',
        'is_featured' // NUEVO
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}