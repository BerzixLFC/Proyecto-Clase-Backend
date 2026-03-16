<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Compra Exitosa - GestiónPro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background-color: #f4f5f7; color: #333; display: flex; flex-direction: column; min-height: 100vh;}
        
        main { 
            flex-grow: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .success-card {
            background: #fff;
            max-width: 600px;
            width: 100%;
            padding: 60px 40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            text-align: center;
            border-top: 5px solid #6b326b;
        }

        .success-icon {
            font-size: 5rem;
            margin-bottom: 20px;
            line-height: 1;
        }

        .success-card h1 {
            font-size: 2.2rem;
            color: #111;
            margin-bottom: 15px;
        }

        .success-card p {
            font-size: 1.1rem;
            color: #666;
            margin-bottom: 40px;
            line-height: 1.6;
        }

        .order-number {
            background: #fafafa;
            padding: 15px;
            border-radius: 8px;
            font-size: 0.95rem;
            color: #888;
            margin-bottom: 40px;
            border: 1px dashed #ddd;
        }
        
        .order-number strong {
            color: #111;
        }

        .btn-continue {
            display: inline-block;
            background: #6b326b;
            color: #fff;
            padding: 16px 35px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: 600;
            transition: 0.2s;
            width: 100%;
        }

        .btn-continue:hover {
            background: #522552;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

    @include('Layouts.navbar')

    <main>
        <div class="success-card">
            <div class="success-icon">🎉</div>
            <h1>¡Tu compra fue un éxito!</h1>
            <p>Hemos recibido tu pedido y nuestro equipo ya está preparándolo para el envío. Te enviaremos un correo con los detalles muy pronto.</p>
            
            <div class="order-number">
                Número de pedido simluado: <strong>#ORD-{{ strtoupper(substr(uniqid(), -6)) }}</strong>
            </div>

            <a href="{{ route('product.index') }}" class="btn-continue">Seguir explorando el catálogo</a>
        </div>
    </main>

    @include('Layouts.footer')
</body>
</html> 