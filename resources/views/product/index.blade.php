<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Catálogo - GestiónPro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        /* (Tu CSS está excelente, lo mantengo igual) */
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

        /* Responsividad */
        @media (max-width: 1300px) {
            .catalogo-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        @media (max-width: 1000px) {
            .catalogo-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 700px) {
            .catalogo-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 500px) {
            .catalogo-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    @include('layouts.navbar')
    <<div class="catalogo-grid">
        @forelse ($miLista as $item)
            <div class="producto-card">
                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
                <div class="card-content">
                    <h3>{{ $item->name }}</h3>
                    <div class="price">${{ number_format($item->price, 2) }} USD</div>
                </div>
                <div class="hover-info">
                    <h4>{{ $item->name }}</h4>
                    <p>{{ $item->description }}</p>
                </div>
            </div>
        @empty
            <div style="grid-column: 1/-1; text-align: center; padding: 50px;">
                <p>No hay productos disponibles por el momento.</p>
            </div>
        @endforelse
        </div>
        </main>
        @include('layouts.footer')
</body>
</html>
