<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke()
    {
        $homeSetting = \App\Models\HomeSetting::first() ?? (object) [
            'hero_title' => 'El futuro de la tecnología, hoy.',
            'hero_description' => 'Descubre nuestro catálogo con los equipos más potentes...',
            'why_us_title' => '¿Por qué escogernos?',
            'why_us_description' => 'Ofrecemos la mejor calidad en equipos...'
        ];

        // AHORA TRAEMOS SOLO LOS MARCADOS COMO DESTACADOS (is_featured = 1)
        $productosDelMomento = \App\Models\Product::where('is_in_stock', 1)
                                                  ->where('is_featured', 1)
                                                  ->latest()
                                                  ->get();

        return view('welcome', compact('homeSetting', 'productosDelMomento'));
    }
}