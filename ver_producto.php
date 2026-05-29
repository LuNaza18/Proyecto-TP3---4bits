<?php

session_start();

if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
    exit();
}

include 'includes/conexion.php';
include 'includes/header.php';
include 'includes/sidebar.php';

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    header('Location: tienda.php');
    exit();
}

$id = intval($_GET['id']);
$product = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT * FROM productos WHERE id='$id'"));

if(!$product){
    header('Location: tienda.php');
    exit();
}
?>

<div class="content">
    <h1 class="mb-4">Producto: <?php echo htmlspecialchars($product['nombre']); ?></h1>
    <div class="card card-custom p-4">
        <p><strong>Descripción:</strong></p>
        <p><?php echo nl2br(htmlspecialchars($product['descripcion'])); ?></p>
        <p><strong>Precio:</strong> $<?php echo htmlspecialchars($product['precio']); ?></p>
        <p><strong>Stock:</strong> <?php echo htmlspecialchars($product['stock']); ?></p>
        <div class="d-flex gap-2">
            <?php if(in_array($_SESSION['rol'], ['admin', 'vendedor'])): ?>
                <a href="editar_producto.php?id=<?php echo $product['id']; ?>" class="btn btn-warning btn-sm btn-custom">Modificar</a>
            <?php endif; ?>
            <a href="tienda.php" class="btn btn-secondary btn-sm btn-custom">Volver</a>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>