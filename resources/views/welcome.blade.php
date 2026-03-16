<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Inicio - GestiónPro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #0b0b0f; color: #f5f5f7; overflow-x: hidden; }
        a { text-decoration: none; color: inherit; transition: 0.3s; }
        
        .btn-primary { background: #fff; color: #000; padding: 12px 30px; border-radius: 30px; font-weight: 600; display: inline-block; transition: 0.3s; }
        .btn-primary:hover { background: #ccc; }
        .btn-outline { border: 1px solid #444; padding: 10px 24px; border-radius: 30px; font-size: 0.9rem; transition: 0.3s; }
        .btn-outline:hover { background: #fff; color: #000; }

        /* HERO CON SLIDER HORIZONTAL */
        .hero { position: relative; height: 75vh; overflow: hidden; margin-bottom: 60px; }
        
        /* Contenedor que se deslizará */
        .hero-slider-track { display: flex; width: 100%; height: 100%; transition: transform 0.8s ease-in-out; }
        .hero-slide { min-width: 100%; height: 100%; background-size: cover; background-position: center; }
        
        /* Capa oscura para que se lea el texto */
        .hero-overlay { position: absolute; top:0; left:0; width:100%; height:100%; background: rgba(11, 11, 15, 0.75); z-index: 2; }
        
        .hero-content { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; z-index: 3; width: 100%; max-width: 800px; padding: 0 20px;}
        .hero h1 { font-size: 4rem; font-weight: 700; line-height: 1.1; margin-bottom: 20px; color: #fff; }
        .hero p { font-size: 1.2rem; color: #ccc; margin-bottom: 30px; }

        /* PRODUCTOS HORIZONTALES */
        .products-section { max-width: 1400px; margin: 0 auto 80px auto; padding: 0 40px; }
        .products-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 25px; }
        .horizontal-scroll { display: flex; overflow-x: auto; gap: 25px; padding-bottom: 20px; scroll-snap-type: x mandatory; }
        .horizontal-scroll::-webkit-scrollbar { height: 8px; }
        .horizontal-scroll::-webkit-scrollbar-track { background: #0b0b0f; }
        .horizontal-scroll::-webkit-scrollbar-thumb { background-color: #444; border-radius: 10px; }

        .product-card { min-width: 280px; flex: 0 0 auto; scroll-snap-align: start; background: #111; border-radius: 12px; overflow: hidden; border: 1px solid #1a1a1f; }
        .product-card:hover { transform: translateY(-5px); border-color: #333; }
        .product-card img { width: 100%; height: 250px; object-fit: cover; }
        .card-info { padding: 15px; }
        .card-info h3 { font-size: 1.1rem; margin-bottom: 5px; font-weight: 500; }
        .card-info .price { color: #8bb9fe; font-weight: 600; }
    </style>
</head>

<body>
    @include('layouts.navbar')

    <section class="hero">
        <div class="hero-slider-track" id="slider-track">
            @php
                // Recopilamos las imágenes verificando que existan (?? false) para evitar el error
                $images = [];
                if($homeSetting->hero_image_1 ?? false) $images[] = $homeSetting->hero_image_1;
                if($homeSetting->hero_image_2 ?? false) $images[] = $homeSetting->hero_image_2;
                if($homeSetting->hero_image_3 ?? false) $images[] = $homeSetting->hero_image_3;
                if($homeSetting->hero_image_4 ?? false) $images[] = $homeSetting->hero_image_4;
            @endphp

            @if(count($images) > 0)
                @foreach($images as $img)
                    <div class="hero-slide" style="background-image: url('{{ asset('storage/' . $img) }}')"></div>
                @endforeach
            @else
                <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&q=80&w=1920')"></div>
            @endif
        </div>

        <div class="hero-overlay"></div>
        
        <div class="hero-content">
            <h1>{{ $homeSetting->hero_title ?? 'El futuro de la tecnología, hoy.' }}</h1>
            <p>{{ $homeSetting->hero_description ?? 'Descubre nuestro catálogo con los equipos más potentes.' }}</p>
            <a href="{{ route('product.index') }}" class="btn-primary">Ver Catálogo Completo</a>
        </div>
    </section>

    <section class="products-section">
        <div class="products-header">
            <h2>Los productos del momento</h2>
            <a href="{{ route('product.index') }}" class="btn-outline">Explorar todo</a>
        </div>

        <div class="horizontal-scroll">
            @if(isset($productosDelMomento) && $productosDelMomento->count() > 0)
                @foreach ($productosDelMomento as $item)
                    <a href="{{ route('product.show', $item->id) }}" class="product-card">
                        @if ($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" alt="Img">
                        @else
                            <img src="https://via.placeholder.com/300x260/222222/cccccc?text=Producto">
                        @endif
                        <div class="card-info">
                            <h3>{{ $item->name }}</h3>
                            <div class="price">${{ number_format($item->price, 2) }} USD</div>
                        </div>
                    </a>
                @endforeach
            @else
                <p style="color: #888;">No has destacado ningún producto. Ve al panel de administrador para seleccionar hasta 10 productos.</p>
            @endif
        </div>
    </section>

    <section class="products-section" style="margin-top: 40px;">
        <div style="background: #111; border: 1px solid #1a1a1f; border-radius: 12px; padding: 80px 40px; text-align: center;">
            <h2 style="font-size: 2.5rem; margin-bottom: 25px; color: #fff;">{{ $homeSetting->why_us_title ?? '¿Por qué escogernos?' }}</h2>
            <p style="font-size: 1.15rem; color: #ccc; max-width: 850px; margin: 0 auto; line-height: 1.7;">
                {{ $homeSetting->why_us_description ?? 'Ofrecemos la mejor calidad en equipos y componentes tecnológicos.' }}
            </p>
        </div>
    </section>

    @include('layouts.footer')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const track = document.getElementById('slider-track');
            const slides = document.querySelectorAll('.hero-slide');
            
            if(slides.length > 1) {
                let currentSlide = 0;
                // Pasa la imagen cada 4 segundos
                setInterval(() => {
                    currentSlide++;
                    if(currentSlide >= slides.length) {
                        currentSlide = 0; // Vuelve al inicio
                    }
                    // Mueve el contenedor horizontalmente
                    track.style.transform = `translateX(-${currentSlide * 100}%)`;
                }, 4000);
            }
        });
    </script>
</body>
</html>