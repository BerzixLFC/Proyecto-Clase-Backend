<style>
    header {
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
        padding: 1.2rem 3rem;
        border-bottom: 1px solid #1a1a1f;
        background-color: #ffffff; /* Ajusta este color según el fondo que necesites */
    }

    .logo {
        font-size: 1.3rem;
        font-weight: 600;
        color: #111;
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
        font-weight: 500;
    }

    nav a:hover {
        color: #6b326b;
    }

    /* Estilos para el área de acciones (derecha) */
    .nav-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
    }

    .btn-admin {
        background-color: #6b326b; 
        color: #fff !important;
        padding: 8px 18px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 600;
        transition: 0.2s;
        border: 1px solid #6b326b;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-admin:hover {
        background-color: #522552;
    }

    .btn-exit-admin {
        background-color: #ff4d4d;
        border-color: #ff4d4d;
    }
    
    .btn-exit-admin:hover {
        background-color: #cc0000;
    }
</style>

<header>
    <div class="logo">GestiónPro</div>

    <nav>
        <a href="{{ route('product.index') }}">Catálogo</a>
        <a href="#">Inventario</a>
        <a href="#">Ventas</a>
        <a href="#">Configuraciones</a>
    </nav>

    <div class="nav-actions">
        {{-- Lógica inteligente: Detecta si estamos en la vista de un producto --}}
        @if(Route::currentRouteName() == 'product.show')
            
            {{-- Si ya estamos en modo admin dentro del producto, mostramos botón para salir --}}
            @if(request()->has('admin') || request()->has('edit'))
                <a href="{{ route('product.show', $product->id) }}" class="btn-admin btn-exit-admin">❌ Salir de Admin</a>
            @else
                {{-- Si somos clientes viendo el producto, mostramos botón para activar admin ahí mismo --}}
                <a href="{{ request()->fullUrlWithQuery(['admin' => 1]) }}" class="btn-admin">⚙️ Activar Admin Aquí</a>
            @endif

        @else
            {{-- Comportamiento normal en cualquier otra pantalla --}}
            <a href="{{ route('product.admin') }}" class="btn-admin">⚙️ Panel Admin</a>
        @endif
    </div>
</header>