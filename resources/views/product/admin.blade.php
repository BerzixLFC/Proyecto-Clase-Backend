<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración - GestiónPro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; display: flex; background-color: #f4f5f7; min-height: 100vh; }
        .sidebar { width: 250px; background-color: #111; color: white; padding: 30px 20px; display: flex; flex-direction: column; }
        .sidebar h2 { font-size: 1.4rem; margin-bottom: 30px; text-align: center; color: #fff; }
        .sidebar a.nav-link { color: #888; text-decoration: none; padding: 12px 15px; margin-bottom: 5px; border-radius: 6px; font-weight: 500; transition: 0.2s; display: block; }
        .sidebar a.nav-link:hover, .sidebar a.nav-link.active { background-color: #333; color: #fff; }
        .sidebar-heading { color: #666; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; margin: 25px 0 10px 15px; font-weight: 700; }
        .category-select { width: 100%; padding: 10px; border-radius: 6px; background-color: #222; color: #fff; border: 1px solid #333; font-family: 'Inter', sans-serif; font-size: 0.9rem; cursor: pointer; outline: none; }
        .volver-tienda { margin-top: auto; color: #ff4d4d !important; text-align: center; border: 1px solid #ff4d4d; border-radius: 6px; padding: 12px 15px; text-decoration: none; font-weight: 500; transition: 0.2s; display: block; }
        .volver-tienda:hover { background-color: #ff4d4d !important; color: #fff !important; }

        .content { flex-grow: 1; padding: 40px; overflow-y: auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .header h1 { color: #333; font-size: 2rem; }
        .header-actions { display: flex; gap: 15px; }
        .btn-new { background-color: #6b326b; color: white; padding: 12px 24px; text-decoration: none; border-radius: 8px; font-weight: 600; border: none; transition: 0.2s; cursor: pointer; display: inline-block;}
        .btn-exit { background-color: #e2e8f0; color: #4a5568; padding: 12px 24px; text-decoration: none; border-radius: 8px; font-weight: 600; transition: 0.2s; border: 1px solid #cbd5e0; }
        
        table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        th, td { padding: 15px 20px; border-bottom: 1px solid #eee; text-align: left; }
        th { background-color: #fafafa; color: #666; font-size: 0.9rem; text-transform: uppercase; }
        .img-cell img { width: 50px; height: 50px; object-fit: cover; border-radius: 6px; }
        .status-in { background: #e0f8e9; color: #1e7e34; padding: 5px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; }
        .status-out { background: #ffe6e6; color: #d73a49; padding: 5px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; }
        .action-btn { background: #f0f0f0; border: none; padding: 8px 12px; border-radius: 6px; cursor: pointer; font-size: 0.85rem; font-weight: 600; }
        .action-btn.edit { background: #e6f2ff; color: #0066cc; }
        .action-btn.delete { background: #ffe6e6; color: #cc0000; }
        .tab-content { display: none; }

        /* Estilos para el seleccionador de productos del home */
        .products-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px; margin-top: 15px; max-height: 400px; overflow-y: auto; padding: 10px; border: 1px solid #eee; border-radius: 8px; background: #fafafa;}
        .product-check-card { background: #fff; padding: 10px; border-radius: 6px; border: 1px solid #ddd; display: flex; align-items: center; gap: 10px; cursor: pointer; }
        .product-check-card img { width: 40px; height: 40px; border-radius: 4px; object-fit: cover;}
        .image-upload-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; }
        .image-box { border: 1px solid #ddd; padding: 15px; border-radius: 8px; }
        .image-box img { max-width: 100px; border-radius: 6px; margin-top: 10px; }
    </style>
</head>
<body>

    @php
        // Filtramos los productos según la categoría seleccionada para la pestaña 1
        $listaFinal = isset($products) ? $products : collect([]);
        if(request()->has('category') && request('category') != "") {
            $listaFinal = $listaFinal->where('category_id', request('category'));
        }
    @endphp

    <div class="sidebar">
        <h2>Panel Admin</h2>
        <a href="#" id="nav-products" class="nav-link active" onclick="showTab('products', event)">📦 Productos</a>
        <a href="#" id="nav-categories" class="nav-link" onclick="showTab('categories', event)">📁 Categorías</a>
        <a href="#" id="nav-landing" class="nav-link" onclick="showTab('landing', event)">🏠 Landing Home</a>
        
        <div id="sidebar-filters">
            <div class="sidebar-heading">Filtrar por Categoría</div>
            <form action="{{ route('product.admin') }}" method="GET" id="categoryForm" style="padding: 0 15px;">
                <input type="hidden" name="tab" value="products">
                <select name="category" class="category-select" onchange="document.getElementById('categoryForm').submit();">
                    <option value="">-- Seleccionar --</option>
                    @foreach($categorias ?? [] as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </form>
        </div>
        
        <a href="{{ url('/') }}" class="volver-tienda">← Salir</a>
    </div>

    <div class="content">
        <div id="tab-products" class="tab-content" style="display: block;">
            <div class="header">
                <h1>Productos</h1>
                <div class="header-actions">
                    <a href="{{ url('/') }}" class="btn-exit">🏠 Ver Tienda</a>
                    <a href="{{ route('product.create') }}" class="btn-new">+ Nuevo Producto</a>
                </div>
            </div>
            <table>
                <thead>
                    <tr><th>Img</th><th>Nombre</th><th>Precio</th><th>Categoría</th><th>Stock</th><th>Acciones</th></tr>
                </thead>
                <tbody>
                    @forelse($listaFinal as $item)
                    <tr>
                        <td class="img-cell">
                            @if ($item->image) <img src="{{ asset('storage/' . $item->image) }}"> @else N/A @endif
                        </td>
                        <td><strong>{{ $item->name }}</strong></td>
                        <td>${{ number_format($item->price, 2) }}</td>
                        <td>{{ $item->category?->name ?? 'N/A' }}</td>
                        <td>{!! $item->is_in_stock ? '<span class="status-in">Sí</span>' : '<span class="status-out">No</span>' !!}</td>
                        <td>
                            <a href="{{ route('product.show', ['id' => $item->id, 'edit' => 1]) }}" class="action-btn edit" style="text-decoration:none">Editar</a>
                            <form action="{{ route('product.destroy', $item->id) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="action-btn delete" onclick="return confirm('¿Eliminar?')">Borrar</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" style="text-align:center;">No hay productos.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div id="tab-categories" class="tab-content">
            <div class="header"><h1>Categorías</h1></div>
            <form action="{{ route('category.store') }}" method="POST" style="margin-bottom: 20px; display: flex; gap: 10px;">
                @csrf
                <input type="text" name="name" placeholder="Nueva Categoría..." required style="padding: 12px; border-radius: 6px; border: 1px solid #ccc; flex-grow: 1;">
                <button type="submit" class="btn-new">Guardar</button>
            </form>
            <table>
                <thead><tr><th>Nombre</th><th>Total Prod.</th><th>Acciones</th></tr></thead>
                <tbody>
                    @forelse($categorias ?? [] as $cat)
                    <tr>
                        <td>
                            <form action="{{ route('category.update', $cat->id) }}" method="POST" style="display:inline;">
                                @csrf @method('PUT')
                                <input type="text" name="name" value="{{ $cat->name }}" required style="padding: 6px; width: 200px;">
                                <button type="submit" class="action-btn edit">Actualizar</button>
                            </form>
                        </td>
                        <td>{{ $cat->products()->count() ?? 0 }}</td>
                        <td>
                            <form action="{{ route('category.destroy', $cat->id) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="action-btn delete" onclick="return confirm('¿Eliminar?')">Borrar</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3" style="text-align:center;">No hay categorías.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div id="tab-landing" class="tab-content">
            <div class="header"><h1>Editar Landing Page</h1></div>

            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" style="background: #fff; padding: 30px; border-radius: 8px;">
                @csrf
                
                <h3 style="color: #6b326b; border-bottom: 2px solid #eee; padding-bottom: 10px;">Sección 1: Cabecera (Hero)</h3>
                <div style="margin-bottom: 15px; margin-top:15px;">
                    <label style="font-weight: 600;">Título</label>
                    <input type="text" name="hero_title" value="{{ $homeSetting?->hero_title ?? '' }}" required style="width: 100%; padding: 10px;">
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="font-weight: 600;">Descripción</label>
                    <textarea name="hero_description" required style="width: 100%; padding: 10px; height: 80px;">{{ $homeSetting?->hero_description ?? '' }}</textarea>
                </div>
                
                <p style="font-weight: 600; margin-bottom: 10px;">Imágenes Carrusel Hero (Mínimo 1, Máximo 4)</p>
                <div class="image-upload-grid">
                    @for($i = 1; $i <= 4; $i++)
                        @php $imgField = 'hero_image_'.$i; @endphp
                        <div class="image-box">
                            <label>Imagen {{ $i }}</label><br>
                            <input type="file" name="hero_image_{{ $i }}" accept="image/*"><br>
                            @if(($homeSetting ?? false) && ($homeSetting->$imgField ?? false))
                                <img src="{{ asset('storage/' . $homeSetting->$imgField) }}">
                                <div><input type="checkbox" name="remove_hero_image_{{ $i }}"> Eliminar imagen actual</div>
                            @endif
                        </div>
                    @endfor
                </div>

                <h3 style="color: #6b326b; border-bottom: 2px solid #eee; padding-bottom: 10px; margin-top: 40px;">Sección 2: Productos del Momento (Máx 10)</h3>
                <div style="margin-top: 15px;">
                    <label style="font-weight: 600;">Filtrar lista por Categoría:</label>
                    <select id="landing-cat-filter" style="padding: 8px; border-radius: 4px;" onchange="filtrarProductosHome()">
                        <option value="all">Todas las categorías</option>
                        @foreach($categorias ?? [] as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    <span style="margin-left: 15px; color: #6b326b; font-weight:bold;">Seleccionados: <span id="contador-productos">0</span> / 10</span>
                </div>
                
                <div class="products-grid" id="productos-lista">
                    @forelse($products ?? [] as $prod)
                        <label class="product-check-card" data-cat="{{ $prod->category_id ?? 'all' }}">
                            <input type="checkbox" name="featured_products[]" value="{{ $prod->id }}" class="prod-checkbox" onchange="validarLimite(this)" {{ ($prod->is_featured ?? false) ? 'checked' : '' }}>
                            @if ($prod->image ?? false)
                                <img src="{{ asset('storage/' . $prod->image) }}">
                            @else
                                <div style="width:40px; height:40px; background:#ddd;"></div>
                            @endif
                            <div style="font-size: 0.85rem; line-height:1.2;">
                                <strong>{{ $prod->name ?? 'Sin Nombre' }}</strong><br>
                                <span style="color:#666;">${{ number_format($prod->price ?? 0, 2) }}</span>
                            </div>
                        </label>
                    @empty
                        <p style="padding: 10px; color: #666;">No hay productos registrados aún.</p>
                    @endforelse
                </div>

                <h3 style="color: #6b326b; border-bottom: 2px solid #eee; padding-bottom: 10px; margin-top: 40px;">Sección 3: ¿Por qué escogernos?</h3>
                <div style="margin-bottom: 15px; margin-top:15px;">
                    <label style="font-weight: 600;">Título</label>
                    <input type="text" name="why_us_title" value="{{ $homeSetting?->why_us_title ?? '' }}" required style="width: 100%; padding: 10px;">
                </div>
                <div style="margin-bottom: 30px;">
                    <label style="font-weight: 600;">Descripción</label>
                    <textarea name="why_us_description" required style="width: 100%; padding: 10px; height: 80px;">{{ $homeSetting?->why_us_description ?? '' }}</textarea>
                </div>

                <button type="submit" class="btn-new" style="width: 100%; font-size: 1.1rem; padding: 15px;">💾 Guardar Todos los Cambios</button>
            </form>
        </div>

    </div>

    <script>
        // Lógica de Tabs
        document.addEventListener("DOMContentLoaded", function() {
            const urlParams = new URLSearchParams(window.location.search);
            const activeTab = urlParams.get('tab') || 'products';
            showTab(activeTab);
            actualizarContador();
        });

        function showTab(tabId, event = null) {
            if(event) event.preventDefault();
            document.querySelectorAll('.tab-content').forEach(el => el.style.display = 'none');
            document.querySelectorAll('.nav-link').forEach(el => el.classList.remove('active'));
            
            const target = document.getElementById('tab-' + tabId);
            if(target) target.style.display = 'block';
            
            const nav = document.getElementById('nav-' + tabId);
            if(nav) nav.classList.add('active');

            const filters = document.getElementById('sidebar-filters');
            if(filters) {
                filters.style.display = (tabId === 'products') ? 'block' : 'none';
            }

            const url = new URL(window.location);
            url.searchParams.set('tab', tabId);
            window.history.pushState({}, '', url);
        }

        // Lógica de filtro del Home y Límite de 10
        function filtrarProductosHome() {
            let catId = document.getElementById('landing-cat-filter').value;
            let cards = document.querySelectorAll('.product-check-card');
            cards.forEach(card => {
                if(catId === 'all' || card.dataset.cat === catId) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        function validarLimite(checkbox) {
            let seleccionados = document.querySelectorAll('.prod-checkbox:checked').length;
            if(seleccionados > 10) {
                alert("¡Has alcanzado el límite de 10 productos destacados!");
                checkbox.checked = false;
            }
            actualizarContador();
        }

        function actualizarContador() {
            let count = document.querySelectorAll('.prod-checkbox:checked').length;
            const contadorEl = document.getElementById('contador-productos');
            if(contadorEl) contadorEl.innerText = count;
        }
    </script>
</body>
</html>