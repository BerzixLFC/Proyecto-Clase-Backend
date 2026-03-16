<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio - GestiónPro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #f4f5f7; color: #333; overflow-x: hidden; }
        a { text-decoration: none; color: inherit; transition: 0.3s; }
        
        .btn-primary { background: #6b326b; color: #fff; padding: 12px 30px; border-radius: 30px; font-weight: 600; display: inline-block; transition: 0.3s; border: none;}
        .btn-primary:hover { background: #522552; }
        .btn-outline { border: 1px solid #6b326b; color: #6b326b; padding: 10px 24px; border-radius: 30px; font-size: 0.9rem; transition: 0.3s; }
        .btn-outline:hover { background: #6b326b; color: #fff; }

        .hero { position: relative; height: 75vh; overflow: hidden; margin-bottom: 50px; }
        .hero-slider-track { display: flex; width: 100%; height: 100%; transition: transform 0.8s ease-in-out; }
        .hero-slide { min-width: 100%; height: 100%; background-size: cover; background-position: center; }
        .hero-overlay { position: absolute; top:0; left:0; width:100%; height:100%; background: rgba(0, 0, 0, 0.5); z-index: 2; }
        
        .hero-content { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; z-index: 3; width: 100%; max-width: 800px; padding: 0 20px;}
        .hero h1 { font-size: 4rem; font-weight: 700; line-height: 1.1; margin-bottom: 20px; color: #fff; text-shadow: 0 2px 10px rgba(0,0,0,0.3); }
        .hero p { font-size: 1.2rem; color: #eee; margin-bottom: 30px; text-shadow: 0 2px 10px rgba(0,0,0,0.3);}

        .products-section { max-width: 1400px; margin: 0 auto 20px auto; padding: 0 40px; }
        .products-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 15px; }
        .products-header h2 { color: #111; }
        
        /* AQUÍ ESTÁ LA MAGIA: Se agregó padding-top: 15px para evitar que el hover corte la tarjeta */
        .horizontal-scroll { display: flex; overflow-x: auto; gap: 25px; padding-top: 15px; padding-bottom: 25px; scroll-snap-type: x mandatory; }
        .horizontal-scroll::-webkit-scrollbar { height: 8px; }
        .horizontal-scroll::-webkit-scrollbar-track { background: #eee; border-radius: 10px;}
        .horizontal-scroll::-webkit-scrollbar-thumb { background-color: #ccc; border-radius: 10px; }

        .product-card { min-width: 280px; flex: 0 0 auto; scroll-snap-align: start; background: #fff; border-radius: 12px; overflow: hidden; border: 1px solid #ddd; }
        .product-card:hover { transform: translateY(-5px); border-color: #6b326b; box-shadow: 0 5px 15px rgba(0,0,0,0.08); }
        .product-card img { width: 100%; height: 250px; object-fit: cover; border-bottom: 1px solid #eee;}
        .card-info { padding: 15px; }
        .card-info h3 { font-size: 1.1rem; margin-bottom: 5px; font-weight: 500; color: #111;}
        .card-info .price { color: #6b326b; font-weight: 600; }
    </style>
</head>

<body>
    @include('Layouts.navbar')

    <section class="hero">
        <div class="hero-slider-track" id="slider-track">
            @php
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
                            <img src="https://via.placeholder.com/300x260/f4f5f7/cccccc?text=Producto">
                        @endif
                        <div class="card-info">
                            <h3>{{ $item->name }}</h3>
                            <div class="price">${{ number_format($item->price, 2) }} USD</div>
                        </div>
                    </a>
                @endforeach
            @else
                <p style="color: #888;">No has destacado ningún producto en el panel administrador.</p>
            @endif
        </div>
    </section>

    <section class="products-section" style="margin-bottom: 60px;">
        <div style="background: #fff; border: 1px solid #ddd; border-radius: 12px; padding: 60px 40px; text-align: center;">
            <h2 style="font-size: 2.5rem; margin-bottom: 25px; color: #111;">{{ $homeSetting->why_us_title ?? '¿Por qué escogernos?' }}</h2>
            <p style="font-size: 1.15rem; color: #555; max-width: 850px; margin: 0 auto; line-height: 1.7;">
                {{ $homeSetting->why_us_description ?? 'Ofrecemos la mejor calidad en equipos y componentes tecnológicos.' }}
            </p>
        </div>
    </section>

    @include('Layouts.footer')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const track = document.getElementById('slider-track');
            const slides = document.querySelectorAll('.hero-slide');
            if(slides.length > 1) {
                let currentSlide = 0;
                setInterval(() => {
                    currentSlide++;
                    if(currentSlide >= slides.length) currentSlide = 0;
                    track.style.transform = `translateX(-${currentSlide * 100}%)`;
                }, 4000);
            }
        });
    </script>
</body>
</html>