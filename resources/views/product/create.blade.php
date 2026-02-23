<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Nuevo Producto</title>

    <style>
        /* Estilos generales para que el fondo sea oscuro y el footer baje */
        body {
            margin: 0;
            padding: 0;
            background-color: #0b0b0f;
            font-family: system-ui, -apple-system, sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex: 1; /* Permite que el contenido empuje el footer hacia abajo */
        }

        /* Tus estilos originales */
        .registro-wrapper {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 60px 20px;
        }

        .form-card {
            background-color: #111;
            border: 1px solid #1f1f25;
            border-radius: 8px;
            padding: 40px;
            width: 100%;
            max-width: 600px;
            color: #f5f5f7;
        }

        .form-card h2 {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 30px;
            letter-spacing: -0.5px;
            margin-top: 0;
        }

        .form-group {
            margin-bottom: 22px;
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-size: 0.9rem;
            color: #aaa;
            margin-bottom: 6px;
            font-weight: 500;
        }

        .form-control {
            background-color: #0f0f14;
            border: 1px solid #222;
            border-radius: 6px;
            padding: 12px 14px;
            color: #fff;
            font-size: 0.95rem;
            outline: none;
            transition: 0.2s ease;
            font-family: inherit;
        }

        .form-control:focus {
            border-color: #8bb9fe;
            box-shadow: 0 0 0 2px rgba(139,185,254,0.2);
        }

        .form-control::placeholder {
            color: #666;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        input[type="file"].form-control {
            padding: 10px;
            background-color: #0f0f14;
            color: #aaa;
        }

        input[type="file"]::file-selector-button {
            background-color: #1f1f25;
            color: #fff;
            border: 1px solid #333;
            padding: 6px 12px;
            margin-right: 12px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.85rem;
            transition: 0.2s;
        }

        input[type="file"]::file-selector-button:hover {
            background-color: #2a2a30;
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23aaa' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 1em;
            padding-right: 35px;
            cursor: pointer;
        }

        .btn-guardar {
            background-color: #ffffff;
            color: #0b0b0f;
            padding: 12px;
            font-size: 0.95rem;
            font-weight: 600;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.2s ease;
            width: 100%;
            margin-top: 10px;
        }

        .btn-guardar:hover {
            background-color: #ffffff;
        }

        .btn-guardar:active {
            transform: scale(0.98);
        }

        .volver-link {
            display: inline-block;
            margin-bottom: 25px;
            color: #ffffff;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .volver-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    @include('Layouts.navbar')

    <main>
        <div class="registro-wrapper">
            <div class="form-card">
                <h2>Registrar Nuevo Producto</h2>

                    <div class="form-group">
                        <label for="nombre">Nombre del Producto</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Ej: MacBook Pro M3" required>
                    </div>

                    <div class="form-group">
                        <label for="precio">Precio (USD)</label>
                        <input type="number" id="precio" name="precio" class="form-control" placeholder="1999.00" step="0.01" min="0" required>
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea id="descripcion" name="descripcion" class="form-control" placeholder="Chip M3, 16GB RAM, 512GB SSD..."></textarea>
                    </div>

                    <div class="form-group">
                        <label for="imagen">Imagen del Producto</label>
                        <input type="file" id="imagen" name="imagen" class="form-control" accept="image/*">
                    </div>

                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <select id="estado" name="estado" class="form-control">
                            <option value="disponible">Disponible</option>
                            <option value="agotado">Agotado</option>
                            <option value="oculto">Oculto</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-guardar">Guardar Producto</button>
                </form>
            </div>
        </div>
    </main>

    @include('Layouts.footer')

</body>
</html>