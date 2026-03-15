<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Catálogo - GestiónPro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #0b0b0f;
            color: #f5f5f7;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            padding: 1.2rem 3rem;
            border-bottom: 1px solid #1a1a1f;
        }

        .logo {
            font-size: 1.3rem;
            font-weight: 600;
            color: #fff;
        }

        nav {
            display: flex;
            gap: 2rem;
            justify-content: center;
        }

        nav a {
            text-decoration: none;
            color: #777;
            font-size: 0.9rem;
            transition: 0.2s;
        }

        nav a:hover {
            color: #fff;
        }

        main {
            flex-grow: 1;
            padding: 2rem 3rem;
            max-width: 1600px;
            margin: 0 auto;
            width: 100%;
        }

        .header-catalogo {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .titulo-pagina {
            font-size: 2.4rem;
            font-weight: 600;
        }

        .btn-nuevo-producto {
            border: 1px solid #333;
            padding: 10px 22px;
            border-radius: 30px;
            color: #fff;
            text-decoration: none;
            font-size: 0.9rem;
            transition: 0.3s;
        }

        .btn-nuevo-producto:hover {
            background: #fff;
            color: #000;
        }

        .catalogo-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 25px;
        }

        .producto-card {
            position: relative;
            background: #111;
            border-radius: 8px;
            overflow: hidden;
            transition: 0.3s ease;
            cursor: pointer;
        }

        .producto-card img {
            width: 100%;
            height: 260px;
            object-fit: cover;
            transition: 0.5s;
        }

        .producto-card:hover img {
            transform: scale(1.05);
        }

        .card-content {
            padding: 14px;
        }

        .card-content h3 {
            font-size: 1rem;
            font-weight: 500;
        }

        .price {
            margin-top: 6px;
            font-size: 0.9rem;
            color: #aaa;
        }

        .hover-info {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.85);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 20px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .producto-card:hover .hover-info {
            opacity: 1;
        }

        /* Responsividad Catálogo */
        @media (max-width: 1300px) {
            .catalogo-grid { grid-template-columns: repeat(4, 1fr); }
        }
        @media (max-width: 1000px) {
            .catalogo-grid { grid-template-columns: repeat(3, 1fr); }
        }
        @media (max-width: 700px) {
            .catalogo-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 500px) {
            .catalogo-grid { grid-template-columns: 1fr; }
        }

        /* ========================================================
           ESTILOS PAGINADOR - ELIMINADOR DE SALTOS DE LÍNEA TAILWIND
           ======================================================== */
        .paginacion-contenedor {
            margin-top: 50px;
            width: 100%;
            display: flex;
            justify-content: center;
            padding-bottom: 20px;
        }

        /* 1. Ocultar vistas móviles extra y texto de resultados */
        .paginacion-contenedor nav > div:first-child,
        .paginacion-contenedor p.text-sm {
            display: none !important;
        }

        /* 2. Forzar a todos los contenedores padre a ser filas horizontales */
        .paginacion-contenedor nav > div:last-child,
        .paginacion-contenedor nav > div:last-child > div {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            justify-content: center !important;
            width: 100% !important;
        }

        /* 3. La caja principal de Tailwind (inline-flex o isolate dependiendo la versión) */
        .paginacion-contenedor .inline-flex,
        .paginacion-contenedor .isolate {
            display: flex !important;
            flex-direction: row !important; /* RESTRINGE ABSOLUTAMENTE A UNA FILA */
            flex-wrap: nowrap !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 8px !important;
            background: transparent !important;
            box-shadow: none !important;
            border: none !important;
        }

        /* 4. Limpiar los botones directos (Cajas de flechas y números) */
        .paginacion-contenedor .inline-flex > *,
        .paginacion-contenedor .isolate > * {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 38px !important;
            height: 38px !important;
            padding: 0 !important;
            margin: 0 !important;
            background: transparent !important;
            border: none !important;
            border-radius: 50% !important;
            color: #aaa !important;
            font-size: 0.95rem !important;
            font-weight: 500 !important;
            text-decoration: none !important;
            box-shadow: none !important;
        }

        /* 5. Asegurar que los spans internos no rompan la caja de 38x38 */
        .paginacion-contenedor .inline-flex > * > *,
        .paginacion-contenedor .isolate > * > * {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 100% !important;
            height: 100% !important;
            background: transparent !important;
            border: none !important;
            border-radius: 50% !important;
            color: inherit !important;
        }

        /* 6. Efecto Hover solo para los links clickeables */
        .paginacion-contenedor a:hover,
        .paginacion-contenedor a:hover > * {
            background: #1f1f25 !important;
            color: #fff !important;
        }

        /* 7. Color de la página activa */
        .paginacion-contenedor span[aria-current="page"] > span {
            background: #2a2a35 !important;
            color: #8bb9fe !important;
            font-weight: 600 !important;
        }

        /* 8. Fijar tamaño del SVG y quitarle márgenes conflictivos */
        .paginacion-contenedor svg {
            width: 18px !important;
            height: 18px !important;
            margin: 0 !important;
            padding: 0 !important;
            display: block !important;
        }
    </style>
</head>

<body>
    @include('layouts.navbar')
    
    <main>
        <div class="header-catalogo">
            <h1 class="titulo-pagina">Catálogo de Productos</h1>
            <a href="{{ route('product.create') }}" class="btn-nuevo-producto">+ Nuevo Producto</a>
        </div>

        <div class="catalogo-grid">
            @forelse ($miLista as $item)
                <a href="{{ route('product.show', $item->id) }}" style="text-decoration: none; color: inherit; display: block;">
                    <div class="producto-card">
                        @if ($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
                        @else
                            <img src="https://via.placeholder.com/300x260/222222/cccccc?text=Sin+Imagen" alt="Sin imagen">
                        @endif
                        
                        <div class="card-content">
                            <h3>{{ $item->name }}</h3>
                            <div class="price">${{ number_format($item->price, 2) }} USD</div>
                        </div>
                        <div class="hover-info">
                            <h4>{{ $item->name }}</h4>
                            <p>{{ Str::limit($item->description, 80) }}</p>
                        </div>
                    </div>
                </a>
            @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 50px;">
                    <p>No hay productos disponibles por el momento.</p>
                </div>
            @endforelse
        </div>

        @if($miLista->hasPages())
            <div class="paginacion-contenedor">
                {{ $miLista->links() }}
            </div>
        @endif
    </main>
    @include('layouts.footer')
</body>
</html>