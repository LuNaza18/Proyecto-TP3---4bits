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

$carrito_error = '';
$carrito_success = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['action']) && $_POST['action'] === 'remove'){
        $producto_id = isset($_POST['producto_id']) ? intval($_POST['producto_id']) : 0;
        if($producto_id > 0 && isset($_SESSION['cart'][$producto_id])){
            unset($_SESSION['cart'][$producto_id]);
            $carrito_success = 'Producto eliminado del carrito.';
        }
    }

    if(isset($_POST['action']) && $_POST['action'] === 'update'){
        foreach($_POST['quantities'] as $producto_id => $cantidad){
            $producto_id = intval($producto_id);
            $cantidad = intval($cantidad);
            if($producto_id > 0 && isset($_SESSION['cart'][$producto_id])){
                if($cantidad <= 0){
                    unset($_SESSION['cart'][$producto_id]);
                } else {
                    $_SESSION['cart'][$producto_id] = $cantidad;
                }
            }
        }
        $carrito_success = 'Carrito actualizado.';
    }

    if(isset($_POST['action']) && $_POST['action'] === 'place_order'){
        $usuario_id = $_SESSION['user_id'] ?? null;
        if(!$usuario_id){
            $carrito_error = 'No se pudo identificar al usuario.';
        } elseif(empty($_SESSION['cart'])){
            $carrito_error = 'El carrito está vacío.';
        } else {
            $total_items = 0;
            foreach($_SESSION['cart'] as $producto_id => $cantidad){
                $producto = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT * FROM productos WHERE id='$producto_id'"));
                if(!$producto){
                    $carrito_error = 'Un producto del carrito no se encontró.';
                    break;
                }
                if($cantidad > intval($producto['stock'])){
                    $carrito_error = 'No hay suficiente stock para ' . htmlspecialchars($producto['nombre']) . '.';
                    break;
                }
            }
if(empty($carrito_error)){

    $total_pedido = 0;

    foreach($_SESSION['cart'] as $producto_id => $cantidad){

        $producto = mysqli_fetch_assoc(
            mysqli_query(
                $conexion,
                "SELECT * FROM productos WHERE id='$producto_id'"
            )
        );

        $total_pedido += ($producto['precio'] * $cantidad);

    }

    mysqli_query(

        $conexion,

        "INSERT INTO pedidos(
            usuario_id,
            total,
            estado
        )

        VALUES(
            '$usuario_id',
            '$total_pedido',
            'pendiente'
        )"

    );

    foreach($_SESSION['cart'] as $producto_id => $cantidad){

        $producto = mysqli_fetch_assoc(
            mysqli_query(
                $conexion,
                "SELECT * FROM productos WHERE id='$producto_id'"
            )
        );

        $nuevo_stock = intval($producto['stock']) - $cantidad;

        mysqli_query(
            $conexion,
            "UPDATE productos
             SET stock='$nuevo_stock'
             WHERE id='$producto_id'"
        );

    }

    $_SESSION['cart'] = [];

    $carrito_success = 'Pedido realizado correctamente.';

}
        }
    }
}

$productos = [];
if(!empty($_SESSION['cart'])){
    $ids = implode(',', array_map('intval', array_keys($_SESSION['cart'])));
    $result = mysqli_query($conexion, "SELECT * FROM productos WHERE id IN ($ids)");
    while($row = mysqli_fetch_assoc($result)){
        $productos[$row['id']] = $row;
    }
}

include 'includes/header.php';
include 'includes/sidebar.php';
?>

<div class="content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Carrito</h1>
        <a href="tienda.php" class="btn btn-primary btn-custom">Seguir comprando</a>
    </div>

    <?php if($carrito_error): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($carrito_error); ?></div>
    <?php endif; ?>

    <?php if($carrito_success): ?>
        <div class="alert alert-success" style="background: #15803d; color: white; border: none;"><?php echo htmlspecialchars($carrito_success); ?></div>
    <?php endif; ?>

    <?php if(empty($_SESSION['cart'])): ?>
        <div class="card card-custom p-4">
            <p>Tu carrito está vacío.</p>
        </div>
    <?php else: ?>
        <form method="POST">
            <input type="hidden" name="action" value="update">
            <div class="card card-custom p-4 mb-4">
                <table class="table table-dark table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $total = 0; foreach($_SESSION['cart'] as $producto_id => $cantidad):
                            $producto = $productos[$producto_id] ?? null;
                            if(!$producto) continue;
                            $subtotal = $producto['precio'] * $cantidad;
                            $total += $subtotal;
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                                <td>$<?php echo htmlspecialchars(number_format($producto['precio'], 2)); ?></td>
                                <td style="width: 140px;">
                                    <input type="number" name="quantities[<?php echo $producto_id; ?>]" class="form-control" min="1" max="<?php echo htmlspecialchars($producto['stock']); ?>" value="<?php echo $cantidad; ?>">
                                </td>
                                <td>$<?php echo htmlspecialchars(number_format($subtotal, 2)); ?></td>
                                <td>
                                    <button type="submit" class="btn btn-secondary btn-sm btn-custom">Actualizar</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </form>

        <div class="d-flex justify-content-between align-items-center">
            <div>
                <form method="POST" style="display:inline-block;">
                    <input type="hidden" name="action" value="place_order">
                    <button type="submit" class="btn btn-success btn-custom">Realizar pedido</button>
                </form>
            </div>
            <h4>Total: $<?php echo htmlspecialchars(number_format($total, 2)); ?></h4>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>