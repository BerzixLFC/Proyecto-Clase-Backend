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

        /* 1. CAMBIO A TEMA CLARO */
        body {
            font-family: 'Inter', sans-serif;
            background: #f8f9fa; /* Fondo blanco/gris claro */
            color: #333; /* Texto oscuro */
            display: flex;
            flex-direction: column;
            min-height: 100vh;
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
            flex-wrap: wrap;
            gap: 15px;
        }

        .titulo-pagina {
            font-size: 2.4rem;
            font-weight: 600;
            color: #111;
        }

        /* 2. BUSCADOR HORIZONTAL (Reemplaza al botón) */
        .filter-form { 
            display: flex; 
            gap: 10px; 
            align-items: center; 
        }
        .filter-input, .filter-select { 
            padding: 10px 15px; 
            border: 1px solid #ccc; 
            border-radius: 6px; 
            font-family: inherit; 
            font-size: 0.95rem; 
            outline: none; 
            background: #fff;
            color: #333;
        }
        .filter-input:focus, .filter-select:focus { 
            border-color: #6b326b; 
        }
        .filter-btn { 
            background: #6b326b; 
            color: #fff; 
            border: none; 
            padding: 10px 20px; 
            border-radius: 6px; 
            font-weight: 600; 
            cursor: pointer; 
            transition: 0.2s;
        }
        .filter-btn:hover { 
            background: #522552; 
        }

        /* 3. TU GRID ORIGINAL DE 5 COLUMNAS */
        .catalogo-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 25px;
        }

        /* 4. TARJETA EN TEMA CLARO MANTENIENDO TU ESTRUCTURA */
        .producto-card {
            position: relative;
            background: #fff; /* Tarjeta blanca */
            border-radius: 8px;
            overflow: hidden;
            transition: 0.3s ease;
            cursor: pointer;
            border: 1px solid #eaeaea; /* Borde sutil */
            box-shadow: 0 4px 10px rgba(0,0,0,0.03);
        }

        .producto-card img {
            width: 100%;
            height: 260px;
            object-fit: cover;
            transition: 0.5s;
            border-bottom: 1px solid #f0f0f0;
        }

        .producto-card:hover img {
            transform: scale(1.05);
        }

        .producto-card:hover {
            border-color: #6b326b;
            box-shadow: 0 8px 20px rgba(107, 50, 107, 0.1);
        }

        .card-content {
            padding: 14px;
        }

        .card-content h3 {
            font-size: 1rem;
            font-weight: 600;
            color: #111;
        }

        .price {
            margin-top: 6px;
            font-size: 1rem;
            color: #6b326b; /* Precio en morado */
            font-weight: 700;
        }

        /* TU EFECTO HOVER INTACTO */
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
            color: #fff;
        }

        .producto-card:hover .hover-info {
            opacity: 1;
        }

        /* Responsividad Catálogo Original */
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
            .header-catalogo { flex-direction: column; align-items: stretch; }
            .filter-form { flex-direction: column; }
            .filter-input, .filter-select, .filter-btn { width: 100%; }
        }

        /* ========================================================
           TUS ESTILOS PAGINADOR INTACTOS (ADAPTADOS A COLOR CLARO)
           ======================================================== */
        .paginacion-contenedor {
            margin-top: 50px;
            width: 100%;
            display: flex;
            justify-content: center;
            padding-bottom: 20px;
        }

        .paginacion-contenedor nav > div:first-child,
        .paginacion-contenedor p.text-sm {
            display: none !important;
        }

        .paginacion-contenedor nav > div:last-child,
        .paginacion-contenedor nav > div:last-child > div {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            justify-content: center !important;
            width: 100% !important;
        }

        .paginacion-contenedor .inline-flex,
        .paginacion-contenedor .isolate {
            display: flex !important;
            flex-direction: row !important;
            flex-wrap: nowrap !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 8px !important;
            background: transparent !important;
            box-shadow: none !important;
            border: none !important;
        }

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
            color: #666 !important; /* Gris oscuro para modo claro */
            font-size: 0.95rem !important;
            font-weight: 500 !important;
            text-decoration: none !important;
            box-shadow: none !important;
        }

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

        /* Hover para modo claro */
        .paginacion-contenedor a:hover,
        .paginacion-contenedor a:hover > * {
            background: #e0e0e0 !important;
            color: #111 !important;
        }

        /* Página activa en modo claro (usando tu morado) */
        .paginacion-contenedor span[aria-current="page"] > span {
            background: #6b326b !important;
            color: #fff !important;
            font-weight: 600 !important;
        }

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
    @include('Layouts.navbar')
    
    <main>
        <div class="header-catalogo">
            <h1 class="titulo-pagina">Catálogo de Productos</h1>
            
            <form action="{{ route('product.index') }}" method="GET" class="filter-form">
                <input type="text" name="search" class="filter-input" placeholder="Buscar producto..." value="{{ request('search') }}">
                <select name="category" class="filter-select">
                    <option value="">Todas las Categorías</option>
                    @foreach($categorias ?? [] as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="filter-btn">Buscar</button>
            </form>
        </div>

        @if(session('success'))
            <div style="background: #e0f8e9; color: #1e7e34; padding: 15px; border-radius: 8px; margin-bottom: 25px; text-align: center; font-weight: 600; border: 1px solid #c3e6cb;">
                🎉 {{ session('success') }}
            </div>
        @endif

        <div class="catalogo-grid">
            @forelse ($miLista as $item)
                <a href="{{ route('product.show', $item->id) }}" style="text-decoration: none; color: inherit; display: block;">
                    <div class="producto-card">
                        @if ($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
                        @else
                            <img src="https://via.placeholder.com/300x260/f8f9fa/cccccc?text=Sin+Imagen" alt="Sin imagen">
                        @endif
                        
                        <div class="card-content">
                            <h3>{{ $item->name }}</h3>
                            <div class="price">${{ number_format($item->price, 2) }}</div>
                        </div>
                        <div class="hover-info">
                            <h4>{{ $item->name }}</h4>
                            <p style="margin-top: 8px; font-size: 0.9rem;">{{ Str::limit($item->description, 80) }}</p>
                        </div>
                    </div>
                </a>
            @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 50px;">
                    <p style="color: #666; font-size: 1.1rem;">No hay productos disponibles por el momento con esos filtros.</p>
                </div>
            @endforelse
        </div>

        @if(isset($miLista) && $miLista->hasPages())
            <div class="paginacion-contenedor">
                {{ $miLista->links() }}
            </div>
        @endif
    </main>
    
    @include('Layouts.footer')
</body>
</html>