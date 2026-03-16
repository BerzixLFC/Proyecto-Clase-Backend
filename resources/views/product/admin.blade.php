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
        
        /* Sidebar Frontal y Básico */
        .sidebar { width: 250px; background-color: #111; color: white; padding: 30px 20px; display: flex; flex-direction: column; }
        .sidebar h2 { font-size: 1.4rem; margin-bottom: 40px; text-align: center; color: #fff; }
        .sidebar a.nav-link { color: #888; text-decoration: none; padding: 12px 15px; margin-bottom: 5px; border-radius: 6px; font-weight: 500; transition: 0.2s; display: block; }
        .sidebar a.nav-link:hover, .sidebar a.nav-link.active { background-color: #222; color: #fff; }
        
        /* Título y Selector de categorías */
        .sidebar-heading { color: #666; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; margin: 25px 0 10px 15px; font-weight: 700; }
        .category-select { width: 100%; padding: 10px; border-radius: 6px; background-color: #222; color: #fff; border: 1px solid #333; font-family: 'Inter', sans-serif; font-size: 0.9rem; cursor: pointer; outline: none; }
        .category-select:focus { border-color: #6b326b; }
        
        .volver-tienda { margin-top: auto; color: #ff4d4d !important; text-align: center; border: 1px solid #ff4d4d; border-radius: 6px; padding: 12px 15px; text-decoration: none; font-weight: 500; transition: 0.2s; display: block; }
        .volver-tienda:hover { background-color: #ff4d4d !important; color: #fff !important; }

        /* Contenedor y Tabla */
        .content { flex-grow: 1; padding: 40px; overflow-y: auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .header h1 { color: #333; font-size: 2rem; }
        
        /* Botones de la cabecera */
        .header-actions { display: flex; gap: 15px; }
        .btn-new { background-color: #6b326b; color: white; padding: 12px 24px; text-decoration: none; border-radius: 8px; font-weight: 600; transition: 0.2s; }
        .btn-new:hover { background-color: #522552; }
        
        .btn-exit { background-color: #e2e8f0; color: #4a5568; padding: 12px 24px; text-decoration: none; border-radius: 8px; font-weight: 600; transition: 0.2s; border: 1px solid #cbd5e0; }
        .btn-exit:hover { background-color: #cbd5e0; color: #2d3748; }
        
        table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        th, td { padding: 15px 20px; border-bottom: 1px solid #eee; text-align: left; }
        th { background-color: #fafafa; color: #666; font-size: 0.9rem; text-transform: uppercase; }
        td { color: #333; font-size: 0.95rem; vertical-align: middle; }
        
        .img-cell img { width: 50px; height: 50px; object-fit: cover; border-radius: 6px; border: 1px solid #eee; }
        .img-placeholder { width: 50px; height: 50px; background: #eee; border-radius: 6px; }
        
        /* Etiquetas de Stock */
        .status-in { background: #e0f8e9; color: #1e7e34; padding: 5px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; }
        .status-out { background: #ffe6e6; color: #d73a49; padding: 5px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; }
        
        /* Botones de Acción Mágicos */
        .action-btn { background: #f0f0f0; color: #333; border: none; padding: 8px 12px; border-radius: 6px; cursor: pointer; text-decoration: none; font-size: 0.85rem; font-weight: 600; margin-right: 5px; }
        .action-btn.edit { background: #e6f2ff; color: #0066cc; }
        .action-btn.delete { background: #ffe6e6; color: #cc0000; }
        
        /* Mensaje de tabla vacía */
        .empty-state { text-align: center; padding: 40px; color: #888; font-size: 1.1rem; }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>Panel Admin</h2>
        
        <a href="{{ route('product.admin') }}" class="nav-link {{ !request()->has('category') ? 'active' : '' }}">
            📦 Todos los Productos
        </a>
        
        <div class="sidebar-heading">Filtrar por Categoría</div>
        
        <form action="{{ route('product.admin') }}" method="GET" id="categoryForm" style="padding: 0 15px;">
            <select name="category" class="category-select" onchange="document.getElementById('categoryForm').submit();">
                <option value="">-- Seleccionar --</option>
                @foreach($categorias as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </form>
        
        <a href="{{ url('/') }}" class="volver-tienda">← Salir del modo Admin</a>
    </div>

    <div class="content">
        <div class="header">
            <h1>
                @if(request()->has('category') && request('category') != "")
                    Productos: {{ $categorias->where('id', request('category'))->first()->name ?? 'Filtrados' }}
                @else
                    Todos los Productos
                @endif
            </h1>
            
            <div class="header-actions">
                <a href="{{ url('/') }}" class="btn-exit">🏠 Ir a la Pantalla Principal</a>
                <a href="{{ route('product.create') }}" class="btn-new">+ Nuevo Producto</a>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Categoría</th>
                    <th>Stock</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($productList as $item)
                <tr>
                    <td class="img-cell">
                        @if ($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" alt="Img">
                        @else
                            <div class="img-placeholder"></div>
                        @endif
                    </td>
                    <td><strong>{{ $item->name }}</strong></td>
                    <td>${{ number_format($item->price, 2) }}</td>
                    <td>{{ $item->category->name ?? 'N/A' }}</td>
                    <td>
                        @if($item->is_in_stock)
                            <span class="status-in">Disponible</span>
                        @else
                            <span class="status-out">Agotado</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('product.show', ['id' => $item->id, 'edit' => 1]) }}" class="action-btn edit">Editar</a>
                        
                        <form action="{{ route('product.destroy', $item->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn delete" onclick="return confirm('¿Seguro que deseas eliminar este producto?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">No hay productos registrados en esta categoría.</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</body>
</html>