@php
    // Obtenemos los datos del carrito directamente desde el Navbar para tenerlos en toda la página
    $navUserId = \Illuminate\Support\Facades\Auth::check() ? \Illuminate\Support\Facades\Auth::id() : (\App\Models\User::first()->id ?? 1);
    $navCartItems = \App\Models\carItem::with('product')->where('user_id', $navUserId)->get();
    
    $navCartTotal = 0;
    foreach($navCartItems as $item) {
        if($item->product) {
            $navCartTotal += $item->product->price * $item->quantity;
        }
    }
    $navCartCount = $navCartItems->sum('quantity');
@endphp

<style>
    header {
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
        padding: 1.2rem 3rem;
        border-bottom: 1px solid #1a1a1f;
        background-color: #ffffff;
        position: relative; /* Importante para el z-index */
        z-index: 900;
    }

    /* EL LOGO AHORA ES CLICKEABLE */
    .logo {
        font-size: 1.3rem;
        font-weight: 600;
        color: #111;
        text-decoration: none;
    }

    nav { display: flex; gap: 2rem; justify-content: center; align-items: center;}
    nav a { text-decoration: none; color: #777; font-size: 0.9rem; transition: 0.2s; font-weight: 500; }
    nav a:hover { color: #6b326b; }

    .nav-actions { display: flex; justify-content: flex-end; align-items: center; }
    .btn-admin { background-color: #6b326b; color: #fff !important; padding: 8px 18px; border-radius: 6px; text-decoration: none; font-size: 0.9rem; font-weight: 600; transition: 0.2s; border: 1px solid #6b326b; display: inline-flex; align-items: center; justify-content: center; }
    .btn-admin:hover { background-color: #522552; }
    .btn-exit-admin { background-color: #ff4d4d; border-color: #ff4d4d; }
    .btn-exit-admin:hover { background-color: #cc0000; }

    /* ESTILOS DEL ICONO DEL CARRITO */
    .cart-trigger { cursor: pointer; position: relative; display: flex; align-items: center; gap: 5px; color: #6b326b; font-weight: bold; font-size: 0.95rem; user-select: none;}
    .cart-trigger:hover { color: #522552; }
    .cart-badge { position: absolute; top: -10px; right: -15px; background: #ff4d4d; color: white; border-radius: 50%; padding: 2px 6px; font-size: 0.75rem; font-weight: 700; }

    /* ESTILOS DEL CARRITO LATERAL (OFF-CANVAS) */
    .cart-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; display: none; opacity: 0; transition: opacity 0.3s; }
    .cart-overlay.active { display: block; opacity: 1; }

    .mini-cart { position: fixed; top: 0; right: -400px; width: 400px; height: 100vh; background: #fff; z-index: 1001; box-shadow: -5px 0 15px rgba(0,0,0,0.1); transition: right 0.3s ease-in-out; display: flex; flex-direction: column; }
    .mini-cart.active { right: 0; }
    
    .mini-cart-header { padding: 20px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; }
    .mini-cart-header h3 { margin: 0; color: #111; font-size: 1.3rem;}
    .close-cart { background: none; border: none; font-size: 2rem; cursor: pointer; color: #999; line-height: 1;}
    .close-cart:hover { color: #333; }

    .mini-cart-body { padding: 20px; flex-grow: 1; overflow-y: auto; }
    .mini-item { display: flex; gap: 15px; margin-bottom: 20px; border-bottom: 1px solid #f9f9f9; padding-bottom: 15px;}
    .mini-item img { width: 65px; height: 65px; object-fit: cover; border-radius: 6px; border: 1px solid #eee; }
    .mini-item-info { flex-grow: 1; }
    .mini-item-info h4 { margin: 0 0 5px 0; font-size: 0.95rem; color: #333; line-height: 1.2;}
    .mini-item-price { font-weight: 600; color: #6b326b; margin-top: 3px; font-size: 0.9rem;}
    
    .remove-mini-item { background: none; border: none; color: #ff4d4d; font-size: 0.8rem; cursor: pointer; padding: 0; text-decoration: underline; margin-top: 5px; font-weight: 500;}

    .mini-cart-footer { padding: 25px 20px; border-top: 1px solid #eee; background: #fafafa; }
    .mini-cart-total { display: flex; justify-content: space-between; font-size: 1.2rem; font-weight: 700; color: #111; margin-bottom: 20px; }
    
    .btn-cart-full { display: block; width: 100%; text-align: center; background: #fff; border: 2px solid #6b326b; color: #6b326b; padding: 12px; border-radius: 8px; font-weight: 600; text-decoration: none; margin-bottom: 12px; transition: 0.2s;}
    .btn-cart-full:hover { background: #f2dff2; }
    
    .btn-cart-checkout { display: block; width: 100%; border: none; background: #6b326b; color: #fff; padding: 14px; border-radius: 8px; font-weight: 600; font-size: 1.05rem; cursor: pointer; transition: 0.2s; text-align: center; text-decoration: none;}
    .btn-cart-checkout:hover { background: #522552; }

    .empty-msg { text-align: center; color: #888; margin-top: 50px; font-size: 1.1rem;}
</style>

<header>
    <a href="{{ url('/') }}" class="logo">GestiónPro</a>

    <nav>
        <a href="{{ route('product.index') }}">Catálogo</a>
        <a href="#">Inventario</a>
        <a href="#">Ventas</a>
        
        <div class="cart-trigger" onclick="toggleCart()">
            🛒 Mi Carrito
            @if($navCartCount > 0)
                <span class="cart-badge">{{ $navCartCount }}</span>
            @endif
        </div>
    </nav>

    <div class="nav-actions">
        @if(Route::currentRouteName() == 'product.show')
            @if(request()->has('admin') || request()->has('edit'))
                <a href="{{ route('product.show', $product->id ?? 1) }}" class="btn-admin btn-exit-admin">❌ Salir de Admin</a>
            @else
                <a href="{{ request()->fullUrlWithQuery(['admin' => 1]) }}" class="btn-admin">⚙️ Activar Admin Aquí</a>
            @endif
        @else
            <a href="{{ route('product.admin') }}" class="btn-admin">⚙️ Panel Admin</a>
        @endif
    </div>
</header>

<div class="cart-overlay" id="cartOverlay" onclick="toggleCart()"></div>

<div class="mini-cart" id="miniCart">
    <div class="mini-cart-header">
        <h3>Tu Carrito ({{ $navCartCount }})</h3>
        <button class="close-cart" onclick="toggleCart()">×</button>
    </div>
    
    <div class="mini-cart-body">
        @if($navCartItems->count() > 0)
            @foreach($navCartItems as $item)
                @if($item->product)
                <div class="mini-item">
                    @if($item->product->image)
                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="Img">
                    @else
                        <div style="width:65px; height:65px; background:#eee; border-radius:6px;"></div>
                    @endif
                    
                    <div class="mini-item-info">
                        <h4>{{ $item->product->name }}</h4>
                        <div style="color: #666; font-size: 0.85rem;">Cant: {{ $item->quantity }}</div>
                        <div class="mini-item-price">${{ number_format($item->product->price * $item->quantity, 2) }}</div>
                        
                        <form action="{{ route('cart.remove', $item->id) }}" method="POST" style="margin:0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="remove-mini-item">Quitar</button>
                        </form>
                    </div>
                </div>
                @endif
            @endforeach
        @else
            <div class="empty-msg">Tu carrito está vacío. 🥺</div>
        @endif
    </div>

    @if($navCartItems->count() > 0)
    <div class="mini-cart-footer">
        <div class="mini-cart-total">
            <span>Total:</span>
            <span>${{ number_format($navCartTotal, 2) }}</span>
        </div>
        
        <a href="{{ route('cart.index') }}" class="btn-cart-full">Ver Carrito Completo</a>
        
        <form action="{{ route('cart.clear') }}" method="POST" style="margin:0;">
            @csrf
            <button type="submit" class="btn-cart-checkout">💳 Finalizar Compra</button>
        </form>
    </div>
    @endif
</div>

<script>
    // Lógica para abrir/cerrar el menú lateral
    function toggleCart() {
        const overlay = document.getElementById('cartOverlay');
        const cart = document.getElementById('miniCart');
        
        if(cart.classList.contains('active')) {
            cart.classList.remove('active');
            setTimeout(() => overlay.classList.remove('active'), 300);
            document.body.style.overflow = 'auto'; // Permitir scroll
        } else {
            overlay.classList.add('active');
            cart.classList.add('active');
            document.body.style.overflow = 'hidden'; // Bloquear scroll de la página de fondo
        }
    }

    // Si el controlador envió la señal de abrir el carrito (cuando agregas algo)
    @if(session('show_cart'))
        document.addEventListener('DOMContentLoaded', () => {
            toggleCart();
        });
    @endif
</script>