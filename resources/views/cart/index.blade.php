<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Carrito - GestiónPro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background-color: #f4f5f7; color: #333; }
        
        main { max-width: 1000px; margin: 50px auto; background: #fff; padding: 40px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        h1 { font-size: 2rem; color: #111; margin-bottom: 30px; border-bottom: 2px solid #eee; padding-bottom: 15px;}
        
        .alert-success { background: #e0f8e9; color: #1e7e34; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-weight: 600; text-align: center; border: 1px solid #c3e6cb;}
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
        th { color: #666; font-size: 0.9rem; text-transform: uppercase; background: #fafafa; }
        td { vertical-align: middle; }
        
        .product-col { display: flex; align-items: center; gap: 15px; }
        .product-col img { width: 60px; height: 60px; border-radius: 6px; object-fit: cover; border: 1px solid #eee; }
        .product-name { font-weight: 600; color: #333; }
        
        .btn-remove { background: #ffe6e6; color: #cc0000; border: none; padding: 8px 12px; border-radius: 6px; cursor: pointer; font-weight: 600; font-size: 0.85rem;}
        
        .cart-summary { background: #fafafa; padding: 25px; border-radius: 8px; text-align: right; border: 1px solid #eee; }
        .total-text { font-size: 1.5rem; color: #111; margin-bottom: 20px; }
        .total-text span { font-weight: 700; color: #6b326b; font-size: 2rem; }
        
        .btn-checkout { background: #6b326b; color: #fff; padding: 15px 30px; border: none; border-radius: 8px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: 0.2s; width: 100%; max-width: 300px;}
        .btn-checkout:hover { background: #522552; }
        .empty-cart { text-align: center; padding: 50px 20px; color: #666; font-size: 1.2rem; }
        .btn-back { display: inline-block; margin-top: 20px; text-decoration: none; color: #6b326b; font-weight: 600; border: 1px solid #6b326b; padding: 10px 20px; border-radius: 6px;}
    </style>
</head>
<body>

    @include('Layouts.navbar')

    <main>
        <h1>🛒 Tu Carrito de Compras</h1>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        @if($cartItems->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio Unitario</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                        @if($item->product)
                        <tr>
                            <td>
                                <div class="product-col">
                                    @if($item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="Img">
                                    @else
                                        <div style="width:60px; height:60px; background:#eee; border-radius:6px;"></div>
                                    @endif
                                    <span class="product-name">{{ $item->product->name }}</span>
                                </div>
                            </td>
                            <td>${{ number_format($item->product->price, 2) }}</td>
                            <td><strong>{{ $item->quantity }}</strong></td>
                            <td style="font-weight: 600; color: #6b326b;">
                                ${{ number_format($item->product->price * $item->quantity, 2) }}
                            </td>
                            <td>
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-remove">X Quitar</button>
                                </form>
                            </td>
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>

            <div class="cart-summary">
                <div class="total-text">Total a Pagar: <span>${{ number_format($total, 2) }}</span></div>
                
                <form action="{{ route('cart.clear') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-checkout">💳 Finalizar Compra</button>
                </form>
            </div>
        @else
            <div class="empty-cart">
                <p>Tu carrito está vacío en este momento.</p>
                <a href="{{ route('product.index') }}" class="btn-back">Ir al Catálogo</a>
            </div>
        @endif
    </main>

    @include('Layouts.footer')
</body>
</html>