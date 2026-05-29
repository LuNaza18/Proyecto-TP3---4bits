<div class="sidebar">

    <h2>Gestión Four</h2>

    <a href="index.php">
        <i class="bi bi-house"></i>
        Dashboard
    </a>

    <?php if(isset($_SESSION['rol']) && in_array($_SESSION['rol'], ['admin', 'vendedor'])): ?>
        <a href="productos.php">
            <i class="bi bi-box"></i>
            Productos
        </a>
    <?php endif; ?>

    <?php if(isset($_SESSION['rol']) && in_array($_SESSION['rol'], ['admin', 'vendedor', 'repartidor'])): ?>
        <a href="pedidos.php">
            <i class="bi bi-cart"></i>
            Pedidos
        </a>
    <?php endif; ?>

    <?php if(isset($_SESSION['rol'])): ?>
        <a href="tienda.php">
            <i class="bi bi-shop"></i>
            Tienda
        </a>
        <a href="carrito.php">
            <i class="bi bi-cart3"></i>
            Carrito
        </a>
    <?php endif; ?>

    <?php if(isset($_SESSION['rol']) && $_SESSION['rol'] === 'user'): ?>
        <a href="mis-pedidos.php">
            <i class="bi bi-bag"></i>
            Mis pedidos
        </a>
    <?php endif; ?>

    <?php if(isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
        <a href="usuarios.php">
            <i class="bi bi-people"></i>
            Usuarios
        </a>
    <?php endif; ?>

    <a href="logout.php">
        <i class="bi bi-box-arrow-right"></i>
        Salir
    </a>

</div>