<?php

session_start();

if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
    exit();
}

include 'includes/conexion.php';

if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = [];
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_to_cart'){
    $producto_id = isset($_POST['producto_id']) ? intval($_POST['producto_id']) : 0;
    $cantidad = isset($_POST['cantidad']) ? intval($_POST['cantidad']) : 1;

    if($producto_id <= 0 || $cantidad <= 0){
        $carrito_error = 'Cantidad o producto inválido.';
    } else {
        $producto = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT * FROM productos WHERE id='$producto_id'"));
        if(!$producto){
            $carrito_error = 'Producto no encontrado.';
        } elseif($cantidad > intval($producto['stock'])){
            $carrito_error = 'No hay suficiente stock disponible.';
        } else {
            if(isset($_SESSION['cart'][$producto_id])){
                $_SESSION['cart'][$producto_id] += $cantidad;
            } else {
                $_SESSION['cart'][$producto_id] = $cantidad;
            }
            $carrito_success = 'Producto agregado al carrito.';
        }
    }
}

$productos = mysqli_query($conexion, "SELECT * FROM productos");
include 'includes/header.php';
include 'includes/sidebar.php';
?>

<div class="content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Tienda</h1>
        <a href="carrito.php" class="btn btn-primary btn-custom">Ver carrito (<?php echo array_sum($_SESSION['cart']); ?>)</a>
    </div>

    <?php if(!empty($carrito_error)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($carrito_error); ?></div>
    <?php endif; ?>

    <?php if(!empty($carrito_success)): ?>
        <div class="alert alert-success" style="background: #15803d; color: white; border: none;"><?php echo htmlspecialchars($carrito_success); ?></div>
    <?php endif; ?>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php while($producto = mysqli_fetch_assoc($productos)): ?>
            <div class="col">
                <div class="card card-custom h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?php echo htmlspecialchars($producto['nombre']); ?></h5>
                        <p class="card-text text-muted mb-2"><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                        <p class="mb-1"><strong>Precio: </strong>$<?php echo htmlspecialchars($producto['precio']); ?></p>
                        <p class="mb-3"><strong>Stock: </strong><?php echo htmlspecialchars($producto['stock']); ?></p>

                        <form method="POST" class="mt-auto">
                            <input type="hidden" name="action" value="add_to_cart">
                            <input type="hidden" name="producto_id" value="<?php echo $producto['id']; ?>">
                            <div class="input-group mb-3">
                                <input type="number" name="cantidad" class="form-control" min="1" max="<?php echo htmlspecialchars($producto['stock']); ?>" value="1" required>
                                <button class="btn btn-success btn-custom" type="submit">Agregar</button>
                            </div>
                        </form>
                        <div class="d-flex gap-2">
                            <a href="ver_producto.php?id=<?php echo $producto['id']; ?>" class="btn btn-info btn-sm btn-custom">Consultar</a>
                            <?php if(in_array($_SESSION['rol'], ['admin', 'vendedor'])): ?>
                                <a href="editar_producto.php?id=<?php echo $producto['id']; ?>" class="btn btn-warning btn-sm btn-custom">Modificar</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>