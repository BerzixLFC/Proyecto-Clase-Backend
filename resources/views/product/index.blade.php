<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Productos</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* --- ESTILOS CSS (MINIMALISTAS & PRO) --- */
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc; /* Fondo gris muy claro */
            color: #334155;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* --- HEADER & NAV --- */
        header {
            background-color: #ffffff;
            padding: 0 2rem;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .brand { font-size: 1.25rem; font-weight: 700; color: #4f46e5; display: flex; align-items: center; gap: 0.5rem; }
        
        nav { display: flex; gap: 2rem; }
        nav a { text-decoration: none; color: #64748b; font-weight: 500; transition: color 0.2s; font-size: 0.95rem; }
        nav a:hover, nav a.active { color: #4f46e5; }

        /* --- MAIN CONTENT --- */
        main {
            flex: 1;
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
            padding: 3rem 1.5rem;
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
        }

        h1 { font-size: 1.875rem; color: #0f172a; font-weight: 700; }
        p.subtitle { color: #64748b; margin-top: 0.25rem; }

        /* Botón de acción */
        .btn-primary {
            background-color: #4f46e5;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.875rem;
            transition: background-color 0.2s;
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.1), 0 2px 4px -1px rgba(79, 70, 229, 0.06);
        }
        .btn-primary:hover { background-color: #4338ca; }

        /* --- GRID SYSTEM --- */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
        }

        /* --- CARD DESIGN --- */
        .card {
            background: white;
            border-radius: 1rem;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
            position: relative;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border-color: #4f46e5;
        }

        /* Imagen */
        .card-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background-color: #f1f5f9;
        }

        /* Badge de Estado */
        .status-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .text-active { color: #16a34a; }
        .text-inactive { color: #dc2626; }
        .text-pending { color: #d97706; }

        /* Contenido de la tarjeta */
        .card-content { padding: 1.5rem; }

        .card-brand {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            color: #94a3b8;
            margin-bottom: 0.25rem;
            letter-spacing: 0.05em;
        }

        .card-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.5rem;
            line-height: 1.4;
        }

        .card-desc {
            font-size: 0.875rem;
            color: #64748b;
            margin-bottom: 1rem;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2; /* Corta el texto en 2 lineas */
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #f1f5f9;
            padding-top: 1rem;
            margin-top: 1rem;
        }

        .price { font-size: 1.25rem; font-weight: 700; color: #0f172a; }
        .details-link { color: #4f46e5; font-size: 0.875rem; font-weight: 600; text-decoration: none; }
        .details-link:hover { text-decoration: underline; }

        /* Footer Pagina */
        footer {
            background-color: white;
            text-align: center;
            padding: 2rem;
            border-top: 1px solid #e2e8f0;
            font-size: 0.875rem;
            color: #94a3b8;
        }
    </style>
</head>
<body>

    @php
        $products = [
            [
                'id' => 1,
                'name' => 'MacBook Pro M3',
                'brand' => 'Apple',
                'price' => 1999.00,
                'description' => 'Chip M3 Pro, 18GB de memoria unificada, 512GB SSD. Potencia extrema.',
                'status' => 'active',
                'image' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca4?auto=format&fit=crop&q=80&w=1000'
            ],
            [
                'id' => 2,
                'name' => 'Sony WH-1000XM5',
                'brand' => 'Sony',
                'price' => 399.99,
                'description' => 'Cancelación de ruido líder en la industria, sonido premium y hasta 30 horas de batería.',
                'status' => 'pending',
                'image' => 'https://images.unsplash.com/photo-1618366712010-f4ae9c647dcb?auto=format&fit=crop&q=80&w=1000'
            ],
            [
                'id' => 3,
                'name' => 'Nike Air Jordan 1',
                'brand' => 'Nike',
                'price' => 180.00,
                'description' => 'El clásico que lo empezó todo. Cuero premium y diseño icónico de 1985.',
                'status' => 'active',
                'image' => 'https://images.unsplash.com/photo-1552346154-21d32810aba3?auto=format&fit=crop&q=80&w=1000'
            ],
            [
                'id' => 4,
                'name' => 'Cámara Fujifilm X-T5',
                'brand' => 'Fujifilm',
                'price' => 1699.00,
                'description' => '40 Megapíxeles, estabilización en el cuerpo y diales retro para control total.',
                'status' => 'inactive',
                'image' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?auto=format&fit=crop&q=80&w=1000'
            ],
            [
                'id' => 5,
                'name' => 'PlayStation 5 Slim',
                'brand' => 'Sony',
                'price' => 499.99,
                'description' => 'Juega como nunca antes. Carga ultrarrápida y gatillos adaptativos.',
                'status' => 'active',
                'image' => 'https://images.unsplash.com/photo-1606813907291-d86efa9b94db?auto=format&fit=crop&q=80&w=1000'
            ],
            [
                'id' => 6,
                'name' => 'Mechanical Keyboard',
                'brand' => 'Keychron',
                'price' => 89.00,
                'description' => 'Teclado mecánico inalámbrico 75% con switches intercambiables.',
                'status' => 'active',
                'image' => 'https://images.unsplash.com/photo-1595225476474-87563907a212?auto=format&fit=crop&q=80&w=1000'
            ]
        ];
    @endphp

    <header>
        <div class="brand">
            <span>⚡</span> ProductManager
        </div>
        <nav>
            <a href="/">Dashboard</a>
            <a href="/product" class="active">Catálogo</a>
            <a href="/product/create">Crear Nuevo</a>
        </nav>
    </header>

    <main>
        <div class="header-section">
            <div>
                <h1>Productos Destacados</h1>
                <p class="subtitle">Gestiona y visualiza tu inventario en tiempo real.</p>
            </div>
            <a href="/product/create" class="btn-primary">+ Nuevo Producto</a>
        </div>

        <div class="product-grid">
            
            @foreach($products as $product)
                <div class="card">
                    
                    <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="card-image">

                    <span class="status-badge 
                        {{ $product['status'] === 'active' ? 'text-active' : '' }}
                        {{ $product['status'] === 'inactive' ? 'text-inactive' : '' }}
                        {{ $product['status'] === 'pending' ? 'text-pending' : '' }}
                    ">
                        {{ $product['status'] == 'active' ? '• Activo' : ($product['status'] == 'inactive' ? '• Inactivo' : '• Pendiente') }}
                    </span>

                    <div class="card-content">
                        <div class="card-brand">{{ $product['brand'] }}</div>
                        <h3 class="card-title">{{ $product['name'] }}</h3>
                        <p class="card-desc">{{ $product['description'] }}</p>

                        <div class="card-footer">
                            <span class="price">${{ number_format($product['price'], 2) }}</span>
                            <a href="#" class="details-link">Ver detalles &rarr;</a>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </main>

    <footer>
        &copy; 2024 ProductManager System. Hecho con Laravel y mucho café ☕.
    </footer>

</body>
</html>