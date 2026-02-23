<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>MacBook Air M3</title>
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

        main {
            flex-grow: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
        }

        .producto-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            max-width: 1200px;
            width: 100%;
            align-items: center;
        }

        .producto-img img {
            width: 100%;
            border-radius: 12px;
        }

        .producto-info h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        .precio {
            font-size: 1.5rem;
            color: #aaa;
            margin-bottom: 25px;
        }

        .descripcion {
            font-size: 1rem;
            line-height: 1.6;
            color: #ccc;
            margin-bottom: 30px;
        }

        .specs {
            margin-bottom: 25px;
        }

        .specs li {
            margin-bottom: 8px;
            color: #aaa;
        }

        /* NUEVO BLOQUE INFO */
        .info-extra {
            margin-bottom: 30px;
            padding: 15px;
            background: #111;
            border: 1px solid #222;
            border-radius: 10px;
        }

        .info-extra p {
            margin-bottom: 8px;
            color: #bbb;
            font-size: 0.95rem;
        }

        /* BOTONES ADMIN */
        .btn-group {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 10px 22px;
            border-radius: 25px;
            border: 1px solid #333;
            text-decoration: none;
            font-size: 0.9rem;
            transition: 0.3s;
            cursor: pointer;
        }

        .btn-editar {
            color: #4da3ff;
            border-color: #4da3ff;
        }

        .btn-editar:hover {
            background: #4da3ff;
            color: #000;
        }

        .btn-eliminar {
            color: #ff4d4d;
            border-color: #ff4d4d;
        }

        .btn-eliminar:hover {
            background: #ff4d4d;
            color: #000;
        }

        .btn-volver {
            color: #fff;
        }

        .btn-volver:hover {
            background: #fff;
            color: #000;
        }

        @media (max-width: 900px) {
            .producto-container {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .producto-info {
                margin-top: 30px;
            }

            .btn-group {
                justify-content: center;
            }
        }
    </style>
</head>
<body>

@include('layouts.navbar')

<main>
    <div class="producto-container">

        <div class="producto-img">
            <img src="https://loremflickr.com/900/700/macbook" alt="MacBook Air M3">
        </div>

        <div class="producto-info">
            <h1>MacBook Air M3</h1>
            <div class="precio">$1.299 USD</div>

            <p class="descripcion">
                La nueva MacBook Air con chip M3 ofrece rendimiento increíble,
                batería de hasta 18 horas y un diseño ultraligero perfecto
                para trabajo y estudio.
            </p>

            <ul class="specs">
                <li>✔ Chip Apple M3</li>
                <li>✔ 16GB de memoria unificada</li>
                <li>✔ SSD 512GB</li>
                <li>✔ Pantalla Liquid Retina 13.6"</li>
                <li>✔ Hasta 18 horas de batería</li>
            </ul>

            <!-- NUEVA SECCIÓN -->
            <div class="info-extra">
                <p><strong>Categoría:</strong> Portátiles</p>
                <p><strong>Stock:</strong> 12 unidades disponibles</p>
                <p><strong>SKU:</strong> MBA-M3-512-16GB</p>
            </div>

            <!-- NUEVOS BOTONES -->
            <div class="btn-group">
                <a href="#" class="btn btn-editar">Editar</a>
                <a href="#" class="btn btn-eliminar">Eliminar</a>
                <a href="#" class="btn btn-volver">Volver al Catálogo</a>
            </div>

        </div>

    </div>
</main>

@include('layouts.footer')

</body>
</html>