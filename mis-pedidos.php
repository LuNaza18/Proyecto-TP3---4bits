<?php

session_start();

if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
    exit();
}

include 'includes/conexion.php';
include 'includes/header.php';
include 'includes/sidebar.php';

$userId = $_SESSION['user_id'] ?? null;
$pedidos = [];
$error = '';

if($userId){
    $query = "SELECT p.id, p.producto_id, p.cantidad, p.estado, prod.nombre AS producto, u.nombre AS usuario
              FROM pedidos p
              LEFT JOIN productos prod ON prod.id = p.producto_id
              LEFT JOIN usuarios u ON u.id = p.usuario_id
              WHERE p.usuario_id = '$userId'";
    $result = mysqli_query($conexion, $query);
    if($result){
        while($row = mysqli_fetch_assoc($result)){
            $pedidos[] = $row;
        }
    } else {
        $error = 'Aún no hay pedidos o la tabla pedidos no está disponible.';
    }
} else {
    $error = 'No se pudo identificar al usuario.';
}
?>

<div class="content">
    <h1>Mis pedidos</h1>
    <?php if($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if(count($pedidos) > 0): ?>
        <div class="card card-custom p-4 mt-4">
            <h4 class="mb-3">Pedido</h4>
            <table class="table table-dark table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($pedidos as $pedido): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($pedido['id']); ?></td>
                            <td><?php echo htmlspecialchars($pedido['producto'] ?: 'Sin nombre'); ?></td>
                            <td><?php echo htmlspecialchars($pedido['cantidad']); ?></td>
                            <td><?php echo htmlspecialchars($pedido['estado']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php elseif(!$error): ?>
        <div class="alert alert-info">No tienes pedidos registrados aún.</div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>