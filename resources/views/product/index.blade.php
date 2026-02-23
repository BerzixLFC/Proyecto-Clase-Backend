<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Catálogo - GestiónPro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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

        /* ===== AQUÍ ESTÁ LA MAGIA ===== */
        main {
            flex-grow: 1;
            padding: 2rem 3rem;
            max-width: 1600px;
            margin: 0 auto; /* Centra horizontalmente */
            width: 100%;
            display: flex; 
            flex-direction: column;
            justify-content: center; /* Centra el contenido verticalmente */
        }

        footer {
            text-align: center;
            padding: 1.2rem;
            font-size: 0.8rem;
            color: #666;
            border-top: 1px solid #1a1a1f;
        }

        /* ===== CATÁLOGO ===== */

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
            background: rgba(0,0,0,0.85);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 20px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .hover-info h4 {
            font-size: 1rem;
            margin-bottom: 8px;
        }

        .hover-info p {
            font-size: 0.85rem;
            color: #ccc;
        }

        .producto-card:hover .hover-info {
            opacity: 1;
        }

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
    </style>
</head>
<body>

@include('layouts.navbar')

<main>

    <div class="header-catalogo">
        <h1 class="titulo-pagina">Catálogo de Productos</h1>
        <a href="#" class="btn-nuevo-producto">+ Nuevo Producto</a>
    </div>

    <div class="catalogo-grid">

        <div class="producto-card">
            <img src="https://loremflickr.com/600/800/macbook">
            <div class="card-content">
                <h3>MacBook Air M3</h3>
                <div class="price">$1.299 USD</div>
            </div>
            <div class="hover-info">
                <h4>MacBook Air M3</h4>
                <p>Chip M3 · 16GB RAM · 18h batería · Ultraligera</p>
            </div>
        </div>

        <div class="producto-card">
            <img src="https://loremflickr.com/600/800/iphone">
            <div class="card-content">
                <h3>iPhone 15 Pro</h3>
                <div class="price">$1.199 USD</div>
            </div>
            <div class="hover-info">
                <h4>iPhone 15 Pro</h4>
                <p>A17 Pro · Titanio · Cámara 48MP · 120Hz</p>
            </div>
        </div>

        <div class="producto-card">
            <img src="https://loremflickr.com/600/800/ipad">
            <div class="card-content">
                <h3>iPad Pro M4</h3>
                <div class="price">$999 USD</div>
            </div>
            <div class="hover-info">
                <h4>iPad Pro M4</h4>
                <p>Pantalla OLED · Apple Pencil Pro · M4</p>
            </div>
        </div>

        <div class="producto-card">
            <img src="https://loremflickr.com/600/800/watch">
            <div class="card-content">
                <h3>Apple Watch Ultra</h3>
                <div class="price">$799 USD</div>
            </div>
            <div class="hover-info">
                <h4>Apple Watch Ultra</h4>
                <p>GPS dual · 36h batería · Titanio</p>
            </div>
        </div>

        <div class="producto-card">
            <img src="https://loremflickr.com/600/800/headphones">
            <div class="card-content">
                <h3>Sony WH-1000XM5</h3>
                <div class="price">$399 USD</div>
            </div>
            <div class="hover-info">
                <h4>Sony WH-1000XM5</h4>
                <p>Cancelación líder · Hi-Res · 30h batería</p>
            </div>
        </div>

        <div class="producto-card">
            <img src="https://loremflickr.com/600/800/laptop">
            <div class="card-content">
                <h3>Dell XPS 15</h3>
                <div class="price">$1.499 USD</div>
            </div>
            <div class="hover-info">
                <h4>Dell XPS 15</h4>
                <p>Intel i9 · RTX · 32GB RAM</p>
            </div>
        </div>

        <div class="producto-card">
            <img src="https://loremflickr.com/600/800/monitor">
            <div class="card-content">
                <h3>LG UltraWide 34"</h3>
                <div class="price">$699 USD</div>
            </div>
            <div class="hover-info">
                <h4>LG UltraWide</h4>
                <p>3440x1440 · 144Hz · IPS</p>
            </div>
        </div>

        <div class="producto-card">
            <img src="https://loremflickr.com/600/800/keyboard">
            <div class="card-content">
                <h3>Keychron K8</h3>
                <div class="price">$199 USD</div>
            </div>
            <div class="hover-info">
                <h4>Keychron K8</h4>
                <p>Mecánico · Bluetooth · RGB</p>
            </div>
        </div>

        <div class="producto-card">
            <img src="https://loremflickr.com/600/800/tablet">
            <div class="card-content">
                <h3>Samsung Galaxy Tab S9</h3>
                <div class="price">$899 USD</div>
            </div>
            <div class="hover-info">
                <h4>Galaxy Tab S9</h4>
                <p>AMOLED 120Hz · Snapdragon 8 Gen 2</p>
            </div>
        </div>

        <div class="producto-card">
            <img src="https://loremflickr.com/600/800/gaming">
            <div class="card-content">
                <h3>ASUS ROG Zephyrus</h3>
                <div class="price">$1.899 USD</div>
            </div>
            <div class="hover-info">
                <h4>ROG Zephyrus</h4>
                <p>RTX 4070 · Ryzen 9 · 240Hz</p>
            </div>
        </div>

    </div>

</main>

@include('layouts.footer')

</body>
</html>