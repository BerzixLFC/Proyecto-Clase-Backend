<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Producto | Dashboard</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        /* --- RESET & BASICS --- */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f3f4f6;
            color: #1f2937;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* --- HEADER & NAV --- */
        header {
            background-color: #ffffff;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            padding: 0 2rem;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo { font-weight: 600; font-size: 1.25rem; color: #4f46e5; display: flex; align-items: center; gap: 8px; }
        nav { display: flex; gap: 2rem; }
        nav a { text-decoration: none; color: #6b7280; font-weight: 500; font-size: 0.95rem; transition: color 0.3s ease; }
        nav a:hover, nav a.active { color: #4f46e5; }

        /* --- MAIN CONTAINER --- */
        main {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 3rem 1rem;
        }

        /* --- CARD FORMULARIO --- */
        .card {
            background: white;
            width: 100%;
            max-width: 600px; /* Un poco más ancho para que quepan bien los inputs dobles */
            border-radius: 16px;
            padding: 2.5rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .card-header { text-align: center; margin-bottom: 2rem; }
        .card-header h2 { font-size: 1.5rem; color: #111827; }
        .card-header p { color: #6b7280; font-size: 0.9rem; margin-top: 5px; }

        /* --- INPUTS & GRID --- */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr; /* Dos columnas iguales */
            gap: 20px;
        }

        /* En móvil, que se ponga en una sola columna */
        @media (max-width: 500px) { .form-grid { grid-template-columns: 1fr; } }

        .form-group { margin-bottom: 1.25rem; }
        .form-group.full-width { grid-column: span 2; } /* Para que descripción e imagen ocupen todo el ancho */
        @media (max-width: 500px) { .form-group.full-width { grid-column: span 1; } }

        label { display: block; margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: 500; color: #374151; }

        input, textarea, select {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            background-color: #f9fafb;
            font-family: inherit;
            font-size: 0.95rem;
            color: #1f2937;
            transition: all 0.2s;
        }

        input:focus, textarea:focus, select:focus {
            outline: none;
            background-color: #fff;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }

        /* Estilo especial para input file */
        input[type="file"] {
            background-color: white;
            padding: 0.5rem;
        }

        /* --- BUTTON --- */
        .btn-submit {
            width: 100%;
            padding: 0.875rem;
            background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.1s ease, box-shadow 0.2s ease;
            margin-top: 1rem;
        }
        .btn-submit:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3); }

        /* --- FOOTER --- */
        footer { text-align: center; padding: 1.5rem; color: #9ca3af; font-size: 0.85rem; border-top: 1px solid #e5e7eb; background: #fff; }
    </style>
</head>
<body>

    <header>
        <div class="logo"><span>⚡</span> ProductManager</div>
        <nav>
            <a href="/">Dashboard</a>
            <a href="/product">Inventario</a>
            <a href="/product/create" class="active">Nuevo</a>
        </nav>
    </header>

    <main>
        <div class="card">
            <div class="card-header">
                <h2>Registrar Producto</h2>
                <p>Completa la información del nuevo ítem</p>
            </div>

            <form action="" method="POST" enctype="multipart/form-data">
                @csrf 

                <div class="form-grid">
                    
                    <div class="form-group">
                        <label for="code">Código (SKU)</label>
                        <input type="text" id="code" name="code" placeholder="Ej. PROD-001" required>
                    </div>

                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" id="name" name="name" placeholder="Ej. iPhone 15" required>
                    </div>

                    <div class="form-group">
                        <label for="price">Precio ($)</label>
                        <input type="number" id="price" name="price" step="0.01" placeholder="0.00" required>
                    </div>

                    <div class="form-group">
                        <label for="status">Estado</label>
                        <select id="status" name="status">
                            <option value="activo">✅ Activo</option>
                            <option value="inactivo">⛔ Inactivo</option>
                            <option value="pendiente">⏳ Pendiente</option>
                        </select>
                    </div>

                    <div class="form-group full-width">
                        <label for="image">Imagen del Producto</label>
                        <input type="file" id="image" name="image" accept="image/*">
                    </div>

                    <div class="form-group full-width">
                        <label for="description">Descripción</label>
                        <textarea id="description" name="description" rows="4" placeholder="Detalles técnicos y características..."></textarea>
                    </div>

                </div> <button type="submit" class="btn-submit">Guardar Producto</button>
            </form>
        </div>
    </main>

    <footer>
        &copy; 2024 ProductManager System. Hecho con Laravel.
    </footer>

</body>
</html>