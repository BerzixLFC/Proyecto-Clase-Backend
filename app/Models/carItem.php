<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class carItem extends Model
{
    // Conectamos con el nombre exacto de tu migración
    protected $table = 'car_items';
    
    // ESTA ES LA LÍNEA QUE QUITA EL ERROR
    protected $fillable = ['quantity', 'user_id', 'product_id'];

    // Relación con el producto
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}