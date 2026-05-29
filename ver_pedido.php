<?php

session_start();

if(!isset($_SESSION['usuario']) || !in_array($_SESSION['rol'], ['admin', 'vendedor', 'repartidor'])){
    header("Location: login.php");
    exit();
}

include 'includes/conexion.php';

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pedido_id']) && is_numeric($_POST['pedido_id'])){
    $pedido_id = intval($_POST['pedido_id']);
    $nuevo_estado = isset($_POST['nuevo_estado']) ? mysqli_real_escape_string($conexion, trim($_POST['nuevo_estado'])) : '';
    $estados_validos = ['Pendiente', 'En camino', 'Entregado'];

    if(in_array($nuevo_estado, $estados_validos)){
        mysqli_query($conexion, "UPDATE pedidos SET estado='$nuevo_estado' WHERE id='$pedido_id'");
        header('Location: ver_pedido.php?id=' . $pedido_id);
        exit();
    }
}

include 'includes/header.php';
include 'includes/sidebar.php';

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    header('Location: pedidos.php');
    exit();
}

$id = intval($_GET['id']);
$query = "SELECT p.*, prod.nombre AS producto, u.nombre AS usuario, u.email AS email_usuario
          FROM pedidos p
          LEFT JOIN productos prod ON prod.id = p.producto_id
          LEFT JOIN usuarios u ON u.id = p.usuario_id
          WHERE p.id='$id'";
$pedido = mysqli_fetch_assoc(mysqli_query($conexion, $query));

if(!$pedido){
    header('Location: pedidos.php');
    exit();
}
?>

<div class="content">
    <h1 class="mb-4">Detalle de pedido #<?php echo htmlspecialchars($pedido['id']); ?></h1>
    <div class="card card-custom p-4">
        <p><strong>Producto:</strong> <?php echo htmlspecialchars($pedido['producto'] ?: 'Sin producto'); ?></p>
        <p><strong>Cliente:</strong> <?php echo htmlspecialchars($pedido['usuario'] ?: 'Sin usuario'); ?> (<?php echo htmlspecialchars($pedido['email_usuario']); ?>)</p>
        <p><strong>Cantidad:</strong> <?php echo htmlspecialchars($pedido['cantidad']); ?></p>
        <p><strong>Estado:</strong> <?php echo htmlspecialchars($pedido['estado']); ?></p>
        <p><strong>Fecha:</strong> <?php echo htmlspecialchars($pedido['fecha'] ?? 'No disponible'); ?></p>
        <div class="d-flex flex-wrap gap-2">
            <?php if($pedido['estado'] !== 'Entregado'): ?>
                <form method="POST" style="display:inline-block; margin-right: 0.5rem;">
                    <input type="hidden" name="pedido_id" value="<?php echo $pedido['id']; ?>">
                    <input type="hidden" name="nuevo_estado" value="Entregado">
                    <button type="submit" class="btn btn-success btn-sm btn-custom">Marcar entregado</button>
                </form>
            <?php endif; ?>
            <?php if($pedido['estado'] !== 'En camino'): ?>
                <form method="POST" style="display:inline-block; margin-right: 0.5rem;">
                    <input type="hidden" name="pedido_id" value="<?php echo $pedido['id']; ?>">
                    <input type="hidden" name="nuevo_estado" value="En camino">
                    <button type="submit" class="btn btn-warning btn-sm btn-custom">Marcar en camino</button>
                </form>
            <?php endif; ?>
            <a href="pedidos.php" class="btn btn-secondary btn-sm btn-custom">Volver</a>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>