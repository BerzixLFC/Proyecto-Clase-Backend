<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Inicio - GestiónPro E-Commerce</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* ========================================================
           RESET Y ESTILOS BASE
           ======================================================== */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #0b0b0f; color: #f5f5f7; overflow-x: hidden; }
        a { text-decoration: none; color: inherit; transition: 0.3s; }
        
        /* Botones */
        .btn-primary { background: #fff; color: #000; padding: 12px 30px; border-radius: 30px; font-weight: 600; display: inline-block; transition: 0.3s; }
        .btn-primary:hover { background: #ccc; }
        .btn-outline { border: 1px solid #444; padding: 10px 24px; border-radius: 30px; font-size: 0.9rem; transition: 0.3s; }
        .btn-outline:hover { background: #fff; color: #000; }

        /* ========================================================
           1. HERO SECTION (Enfoque Tecnológico)
           ======================================================== */
        .hero {
            position: relative;
            height: 75vh; /* Un poco menos alto para ver rápido los productos */
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            /* Fondo tecnológico oscuro */
            background: linear-gradient(rgba(11, 11, 15, 0.75), rgba(11, 11, 15, 0.95)), url('https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&q=80&w=1920') center/cover;
            padding: 0 20px;
            margin-bottom: 60px;
        }
        .hero-content { max-width: 800px; z-index: 2; }
        .hero h1 { font-size: 4rem; font-weight: 700; line-height: 1.1; margin-bottom: 20px; color: #fff; }
        .hero p { font-size: 1.2rem; color: #ccc; margin-bottom: 30px; }

        /* ========================================================
           2. SECCIÓN DE PRODUCTOS (Reutilizable)
           ======================================================== */
        .products-section { max-width: 1400px; margin: 0 auto 80px auto; padding: 0 40px; }
        .products-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 25px; }
        .products-header h2 { font-size: 2rem; font-weight: 600; }
        
        /* Contenedor del scroll horizontal */
        .horizontal-scroll {
            display: flex;
            overflow-x: auto;
            gap: 25px;
            padding-bottom: 20px;
            scroll-snap-type: x mandatory;
            scrollbar-width: thin;
            scrollbar-color: #444 #0b0b0f;
        }
        
        .horizontal-scroll::-webkit-scrollbar { height: 8px; }
        .horizontal-scroll::-webkit-scrollbar-track { background: #0b0b0f; }
        .horizontal-scroll::-webkit-scrollbar-thumb { background-color: #444; border-radius: 10px; }

        .product-card {
            min-width: 280px;
            flex: 0 0 auto;
            scroll-snap-align: start;
            background: #111;
            border-radius: 12px;
            overflow: hidden;
            transition: 0.3s;
            border: 1px solid #1a1a1f;
        }
        .product-card:hover { transform: translateY(-5px); border-color: #333; }
        .product-card img { width: 100%; height: 250px; object-fit: cover; }
        .card-info { padding: 15px; }
        .card-info h3 { font-size: 1.1rem; margin-bottom: 5px; font-weight: 500; }
        .card-info .price { color: #8bb9fe; font-weight: 600; }

        /* Responsividad */
        @media (max-width: 900px) {
            .hero h1 { font-size: 2.5rem; }
            .products-header h2 { font-size: 1.5rem; }
            .products-section { padding: 0 20px; }
        }
    </style>
</head>

<body>
    @include('layouts.navbar')

    <section class="hero">
        <div class="hero-content">
            <h1>El futuro de la tecnología, hoy.</h1>
            <p>Descubre nuestro catálogo con los equipos más potentes, componentes de última generación y accesorios para llevar tu rendimiento al máximo nivel.</p>
            <a href="{{ route('product.index') }}" class="btn-primary">Ver Catálogo Completo</a>
        </div>
    </section>

    <section class="products-section">
        <div class="products-header">
            <h2>Laptops y Computación</h2>
            <a href="{{ route('product.index') }}" class="btn-outline">Ver todos</a>
        </div>

        <div class="horizontal-scroll">
            @if(isset($miLista) && $miLista->count() > 0)
                @foreach ($miLista->take(10) as $item)
                    <a href="{{ route('product.show', $item->id) }}" class="product-card">
                        @if ($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
                        @else
                            <img src="https://via.placeholder.com/300x260/222222/cccccc?text=Computación" alt="Sin imagen">
                        @endif
                        <div class="card-info">
                            <h3>{{ $item->name }}</h3>
                            <div class="price">${{ number_format($item->price, 2) }} USD</div>
                        </div>
                    </a>
                @endforeach
            @else
                @for ($i = 1; $i <= 8; $i++)
                    <a href="#" class="product-card">
                        <img src="https://via.placeholder.com/300x260/1a1a24/8bb9fe?text=Laptop+Pro+{{ $i }}" alt="Laptop">
                        <div class="card-info">
                            <h3>Laptop UltraBook Gen {{ $i }}</h3>
                            <div class="price">$1,299.00 USD</div>
                        </div>
                    </a>
                @endfor
            @endif
        </div>
    </section>

    <section class="products-section">
        <div class="products-header">
            <h2>Smartphones y Tablets</h2>
            <a href="{{ route('product.index') }}" class="btn-outline">Ver todos</a>
        </div>

        <div class="horizontal-scroll">
            {{-- En un futuro aquí podrías filtrar: $miLista->where('categoria', 'smartphones')->take(10) --}}
            @if(isset($miLista) && $miLista->count() > 0)
                @foreach ($miLista->take(10) as $item)
                    <a href="{{ route('product.show', $item->id) }}" class="product-card">
                        @if ($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
                        @else
                            <img src="https://via.placeholder.com/300x260/222222/cccccc?text=Smartphone" alt="Sin imagen">
                        @endif
                        <div class="card-info">
                            <h3>{{ $item->name }}</h3>
                            <div class="price">${{ number_format($item->price, 2) }} USD</div>
                        </div>
                    </a>
                @endforeach
            @else
                @for ($i = 1; $i <= 8; $i++)
                    <a href="#" class="product-card">
                        <img src="https://via.placeholder.com/300x260/2a1a24/fe8b8b?text=Smartphone+X{{ $i }}" alt="Smartphone">
                        <div class="card-info">
                            <h3>Smartphone Serie X{{ $i }}</h3>
                            <div class="price">$799.00 USD</div>
                        </div>
                    </a>
                @endfor
            @endif
        </div>
    </section>

    <section class="products-section">
        <div class="products-header">
            <h2>Audio y Periféricos</h2>
            <a href="{{ route('product.index') }}" class="btn-outline">Ver todos</a>
        </div>

        <div class="horizontal-scroll">
            @if(isset($miLista) && $miLista->count() > 0)
                @foreach ($miLista->take(10) as $item)
                    <a href="{{ route('product.show', $item->id) }}" class="product-card">
                        @if ($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
                        @else
                            <img src="https://via.placeholder.com/300x260/222222/cccccc?text=Audio" alt="Sin imagen">
                        @endif
                        <div class="card-info">
                            <h3>{{ $item->name }}</h3>
                            <div class="price">${{ number_format($item->price, 2) }} USD</div>
                        </div>
                    </a>
                @endforeach
            @else
                @for ($i = 1; $i <= 8; $i++)
                    <a href="#" class="product-card">
                        <img src="https://via.placeholder.com/300x260/1a241a/8bfe9d?text=Auriculares+V{{ $i }}" alt="Audio">
                        <div class="card-info">
                            <h3>Auriculares Inalámbricos V{{ $i }}</h3>
                            <div class="price">$149.00 USD</div>
                        </div>
                    </a>
                @endfor
            @endif
        </div>
    </section>

    @include('layouts.footer')
</body>
</html>