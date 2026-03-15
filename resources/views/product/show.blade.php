<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $product->name }} - HOMELY.</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-purple: #6b326b;
            --soft-pink: #f2dff2;
            --dark-text: #333333;
            --gray-text: #757575;
            --bg-cream: #fffaf6;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background-color: var(--bg-cream); color: var(--dark-text); }

        main { 
            max-width: 1400px; 
            margin: 20px auto; 
            background: #fff; 
            padding: 50px;
            border-radius: 8px;
            display: grid;
            grid-template-columns: 1.2fr 0.8fr; 
            gap: 60px;
        }

        /* 1. GALERÍA */
        .gallery-container { display: flex; gap: 20px; }
        .thumbnails { display: flex; flex-direction: column; gap: 12px; }
        .thumbnails img { 
            width: 80px; 
            height: 80px; 
            object-fit: cover; 
            border-radius: 6px; 
            border: 1px solid #eee; 
            cursor: pointer; /* Cambia el cursor a mano para indicar que se puede hacer clic */
            transition: border-color 0.2s;
        }
        .thumbnails img:hover { border-color: var(--primary-purple); } /* Efecto hover para la miniatura */
        .thumbnails img.active { border-color: var(--primary-purple); border-width: 2px; } /* Estilo para la miniatura activa */
        
        .main-image { flex-grow: 1; display: flex; align-items: center; justify-content: center;}
        .main-image img { 
            max-width: 100%; 
            max-height: 600px; /* Limita la altura máxima de la imagen principal */
            border-radius: 12px; 
            object-fit: contain; 
        }

        /* 2. INFO PRODUCTO */
        .product-info { display: flex; flex-direction: column; }
        .category-tag { font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1.2px; color: var(--gray-text); margin-bottom: 8px; font-weight: 600; }
        .product-title { font-size: 2.8rem; font-weight: 700; margin-bottom: 15px; color: #000; line-height: 1.1; }
        .price { font-size: 2.2rem; font-weight: 700; color: var(--primary-purple); margin-bottom: 25px; }

        /* CARACTERÍSTICAS Y FEATURES */
        .specs-row {
            display: grid; grid-template-columns: 1fr 1fr; gap: 20px;
            margin-bottom: 30px; padding: 20px 0;
            border-top: 1px solid #f0f0f0; border-bottom: 1px solid #f0f0f0;
        }
        .specs-row h3 { font-size: 0.95rem; margin-bottom: 8px; color: #000; text-transform: uppercase; letter-spacing: 0.5px; }
        .specs-row ul { list-style: none; font-size: 0.9rem; color: var(--gray-text); line-height: 1.4; }

        /* BOTONES DE COMPRA */
        .actions { display: flex; flex-direction: column; gap: 12px; margin-bottom: 30px; }
        .btn-add { background: var(--soft-pink); color: var(--primary-purple); border: none; padding: 18px; font-weight: 600; border-radius: 8px; cursor: pointer; font-size: 1rem; }
        .btn-buy { background: var(--primary-purple); color: #fff; border: none; padding: 18px; font-weight: 600; border-radius: 8px; cursor: pointer; font-size: 1rem; }
        
        /* BOTONES DESHABILITADOS (SIN STOCK) */
        .btn-disabled { background: #e0e0e0; color: #a0a0a0; border: none; padding: 18px; font-weight: 600; border-radius: 8px; cursor: not-allowed; font-size: 1rem; }
        .stock-warning { color: #ff4d4d; font-size: 0.9rem; font-weight: 600; text-align: center; margin-top: 5px; }

        /* DESCRIPCIÓN */
        .description-section { margin-top: 10px; padding-top: 20px; }
        .description-section h3 { font-size: 1.1rem; margin-bottom: 10px; color: #000; }
        .description-section p { font-size: 0.95rem; color: var(--gray-text); line-height: 1.6; }

        /* Admin Actions */
        .admin-bar { grid-column: span 2; border-top: 1px solid #eee; padding-top: 30px; display: flex; gap: 20px; justify-content: center; margin-top: 20px; }

        /* MODAL DE EDICIÓN (Expandido) */
        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); display: none; justify-content: center; align-items: center; z-index: 1000; padding: 20px; }
        .modal-overlay.active { display: flex; }
        .modal-content { background: #fff; width: 100%; max-width: 800px; padding: 35px; border-radius: 12px; max-height: 90vh; overflow-y: auto; box-shadow: 0 10px 40px rgba(0,0,0,0.2); }
        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; border-bottom: 1px solid #eee; padding-bottom: 15px; }
        .modal-header h2 { color: var(--primary-purple); margin: 0; font-size: 1.5rem; }
        .close-btn { background: none; border: none; font-size: 1.8rem; cursor: pointer; color: #999; line-height: 1; transition: 0.2s; }
        
        /* Grid para el formulario interior */
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .form-group { margin-bottom: 20px; }
        .form-group.full-width { grid-column: span 2; }
        .form-group label { display: block; margin-bottom: 8px; color: var(--dark-text); font-weight: 600; font-size: 0.95rem;}
        .form-control { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-family: 'Inter', sans-serif; font-size: 0.95rem; }
        .form-control:focus { outline: none; border-color: var(--primary-purple); box-shadow: 0 0 0 2px var(--soft-pink); }
        
        .image-grid { display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 15px; margin-top: 10px; }
        .img-box { border: 2px dashed #e0e0e0; padding: 15px 10px; text-align: center; border-radius: 8px; background: var(--bg-cream); transition: 0.3s; }
        .img-box img { max-width: 100%; height: 60px; object-fit: cover; border-radius: 6px; margin-bottom: 10px; border: 1px solid #eee; }
        
        .btn-save { background: var(--primary-purple); color: #fff; border: none; padding: 16px 20px; border-radius: 8px; cursor: pointer; width: 100%; font-weight: 600; font-size: 1rem; margin-top: 20px; transition: 0.2s; }

        @media (max-width: 1024px) { 
            main { grid-template-columns: 1fr; } 
            .specs-row, .form-grid, .image-grid, .gallery-container { grid-template-columns: 1fr; }
            .gallery-container { flex-direction: column-reverse; } /* Invierte el orden en móvil: imagen principal arriba, thumbnails abajo */
            .thumbnails { flex-direction: row; justify-content: center; overflow-x: auto; padding-bottom: 10px; } /* Thumbnails en fila horizontal con scroll */
        }
    </style>
</head>
<body>

@include('layouts.navbar')

<main>
    <div class="gallery-container">
        {{-- Recolectamos todas las imágenes disponibles en un array --}}
        @php 
            $allImages = array_filter([$product->image, $product->image_2, $product->image_3, $product->image_4]); 
            $firstImage = count($allImages) > 0 ? asset('storage/' . reset($allImages)) : asset('images/product-default.png');
        @endphp

        {{-- Solo mostramos la columna de miniaturas si hay más de una imagen --}}
        @if(count($allImages) > 1)
            <div class="thumbnails" id="productThumbnails">
                @foreach($allImages as $img)
                    <img src="{{ asset('storage/' . $img) }}" alt="thumb" class="{{ $loop->first ? 'active' : '' }}">
                @endforeach
            </div>
        @endif
        
        <div class="main-image">
            {{-- Le damos un ID a la imagen principal para poder cambiarla con JS --}}
            <img src="{{ $firstImage }}" alt="{{ $product->name }}" id="mainProductImage">
        </div>
    </div>

    <div class="product-info">
        <div class="category-tag">{{ $product->category->name ?? 'Categoría' }}</div>
        <h1 class="product-title">{{ $product->name }}</h1>
        <div class="price">${{ number_format($product->price, 2) }}</div>

        <div class="specs-row">
            <div class="col">
                <h3>Características</h3>
                <ul>
                    @if($product->specifications)
                        @foreach(explode("\n", $product->specifications) as $spec)
                            @if(trim($spec))
                                <li>• {{ trim($spec) }}</li>
                            @endif
                        @endforeach
                    @else
                        <li>No hay especificaciones</li>
                    @endif
                </ul>
            </div>
            <div class="col">
                <h3>Features</h3>
                <ul>
                    <li><strong>SKU:</strong> {{ 'MBA-' . strtoupper(substr(md5($product->id), 0, 8)) }}</li>
                    <li><strong>Disponibilidad:</strong> 
                        @if($product->is_in_stock)
                            <span style="color: #28a745; font-weight: 600;">En Stock</span>
                        @else
                            <span style="color: #ff4d4d; font-weight: 600;">Agotado</span>
                        @endif
                    </li>
                </ul>
            </div>
        </div>

        {{-- LÓGICA DE BOTONES SEGÚN STOCK --}}
        @if($product->is_in_stock)
            <div class="actions">
                <button class="btn-add">Añadir al Carrito</button>
                <button class="btn-buy">Comprar Ahora</button>
            </div>
        @else
            <div class="actions">
                <button class="btn-disabled" disabled>Agotado</button>
                <p class="stock-warning">Este producto se encuentra agotado temporalmente.</p>
            </div>
        @endif

        <div class="description-section">
            <h3>Descripción</h3>
            <p>{{ $product->description }}</p>
        </div>
    </div>

    <div class="admin-bar">
        <a href="{{ route('product.index') }}" style="text-decoration: none; color: var(--gray-text)">Volver al catálogo</a>
        <a href="#" onclick="openModal(); return false;" style="text-decoration: none; color: #4da3ff; font-weight: 600;">Editar Producto</a>
        <a href="#" style="text-decoration: none; color: #ff4d4d; font-weight: 600;">Eliminar</a>
    </div>
</main>

{{-- MODAL DE EDICIÓN COMPLETA --}}
<div class="modal-overlay" id="editModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Editar Producto</h2>
            <button class="close-btn" onclick="closeModal()">×</button>
        </div>
        
        <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div class="form-group">
                    <label>Nombre del Producto</label>
                    <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                </div>
                
                <div class="form-group">
                    <label>Precio (USD)</label>
                    <input type="number" step="0.01" name="price" class="form-control" value="{{ $product->price }}" required>
                </div>

                <div class="form-group">
                    <label>Categoría</label>
                    <select name="category_id" class="form-control" required>
                        @foreach($categorias as $cat)
                            <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Estado del Stock</label>
                    <select name="is_in_stock" class="form-control">
                        <option value="1" {{ $product->is_in_stock ? 'selected' : '' }}>✔ En Stock (Disponible para comprar)</option>
                        <option value="0" {{ !$product->is_in_stock ? 'selected' : '' }}>✖ Agotado (Deshabilitar botones)</option>
                    </select>
                </div>

                <div class="form-group full-width">
                    <label>Descripción</label>
                    <textarea name="description" class="form-control" rows="3" required>{{ $product->description }}</textarea>
                </div>

                <div class="form-group full-width">
                    <label>Características (Una por línea)</label>
                    <textarea name="specifications" class="form-control" rows="4">{{ $product->specifications }}</textarea>
                </div>
            </div>

            <div class="form-group">
                <label style="color: var(--primary-purple); font-weight: 700; border-top: 1px solid #eee; padding-top: 20px;">Imágenes del Producto (Máx 4)</label>
                <div class="image-grid">
                    @php
                        $imgFields = ['image' => 'imagen', 'image_2' => 'imagen_2', 'image_3' => 'imagen_3', 'image_4' => 'imagen_4'];
                    @endphp

                    @foreach($imgFields as $dbCol => $inputName)
                        <div class="img-box">
                            <label style="font-size: 0.8rem; color: var(--gray-text);">Ranura {{ $loop->iteration }}</label>
                            @if($product->$dbCol)
                                <br><img src="{{ asset('storage/' . $product->$dbCol) }}" alt="Img"><br>
                                <label style="font-size: 0.8rem; color: #ff4d4d; cursor: pointer;">
                                    <input type="checkbox" name="remove_{{ $dbCol }}" value="1"> Eliminar
                                </label>
                            @else
                                <div style="font-size: 0.8rem; color: #aaa; margin: 15px 0;">Vacía</div>
                            @endif
                            <input type="file" name="{{ $inputName }}" style="font-size: 0.7rem; width: 100%; margin-top: 10px;" accept="image/*">
                        </div>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="btn-save">Guardar Todos los Cambios</button>
        </form>
    </div>
</div>

@include('layouts.footer')

<script>
    // --- LÓGICA DEL MODAL ---
    function openModal() { 
        document.getElementById('editModal').classList.add('active'); 
        document.body.style.overflow = 'hidden'; 
    }
    
    function closeModal() { 
        document.getElementById('editModal').classList.remove('active'); 
        document.body.style.overflow = 'auto'; 
    }

    window.onclick = function(event) {
        var modal = document.getElementById('editModal');
        if (event.target == modal) {
            closeModal();
        }
    }

    // --- LÓGICA DE LA GALERÍA DE IMÁGENES ---
    // Obtenemos las referencias a los elementos una sola vez
    const mainImage = document.getElementById('mainProductImage');
    const thumbnailsContainer = document.getElementById('productThumbnails');

    // Verificamos si existe el contenedor de miniaturas (solo aparece si hay > 1 imagen)
    if (thumbnailsContainer) {
        const thumbnails = thumbnailsContainer.getElementsByTagName('img');

        // Escuchamos el evento click en el contenedor (delegación de eventos)
        thumbnailsContainer.addEventListener('click', function(event) {
            // Comprobamos que el elemento clickeado es una imagen de miniatura
            if (event.target.tagName === 'IMG') {
                const clickedThumbnail = event.target;

                // 1. Actualizamos la fuente de la imagen principal con la fuente de la miniatura clickeada
                mainImage.src = clickedThumbnail.src;

                // 2. Actualizamos la clase 'active' para el estilo visual
                // Removemos 'active' de todas las miniaturas
                for (let i = 0; i < thumbnails.length; i++) {
                    thumbnails[i].classList.remove('active');
                }
                // Añadimos 'active' a la miniatura que ha recibido el clic
                clickedThumbnail.classList.add('active');
            }
        });
    }
</script>

</body>
</html>