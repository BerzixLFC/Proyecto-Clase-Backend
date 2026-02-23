<style>
    header {
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
        padding: 1.2rem 3rem;
        border-bottom: 1px solid #1a1a1f;
    }

    .logo {
        font-size: 1.3rem;
        font-weight: 600;
        color: #fff;
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
    }

    nav a:hover {
        color: #fff;
    }
</style>

<header>
    <div class="logo">GestiónPro</div>

    <nav>
        <a href="#">Dashboard</a>
        <a href="#">Inventario</a>
        <a href="#">Ventas</a>
        <a href="#">Configuraciones</a>
    </nav>

    <div></div>
</header>