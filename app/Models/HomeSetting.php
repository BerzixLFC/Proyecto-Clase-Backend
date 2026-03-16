<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeSetting extends Model
{
    protected $table = 'home_settings';
    
    protected $fillable = [
        'hero_title', 
        'hero_description', 
        'why_us_title', 
        'why_us_description',
        'hero_image_1',
        'hero_image_2',
        'hero_image_3',
        'hero_image_4'
    ];
}