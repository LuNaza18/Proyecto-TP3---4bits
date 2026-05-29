<?php

session_start();

if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
    exit();
}

include 'includes/conexion.php';

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    header("Location: productos.php");
    exit();
}

$id = intval($_GET['id']);

$consulta = mysqli_query($conexion, "SELECT * FROM productos WHERE id='$id'");
$producto = mysqli_fetch_assoc($consulta);

if(!$producto){
    header("Location: productos.php");
    exit();
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nombre = mysqli_real_escape_string($conexion, trim($_POST['nombre']));
    $descripcion = mysqli_real_escape_string($conexion, trim($_POST['descripcion']));
    $precio = floatval($_POST['precio']);
    $stock = intval($_POST['stock']);

    mysqli_query(
        $conexion,
        "UPDATE productos SET nombre='$nombre', descripcion='$descripcion', precio='$precio', stock='$stock' WHERE id='$id'"
    );

    header("Location: productos.php");
    exit();
}

?>

<?php include 'includes/header.php'; ?>

<?php include 'includes/sidebar.php'; ?>

<div class="content">

    <h1 class="mb-4">Editar Producto</h1>

    <div class="card card-custom p-4">

        <form method="POST">

            <div class="mb-3">
                <label>Nombre</label>
                <input type="text" name="nombre" class="form-control" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required>
            </div>

            <div class="mb-3">
                <label>Descripción</label>
                <textarea name="descripcion" class="form-control"><?php echo htmlspecialchars($producto['descripcion']); ?></textarea>
            </div>

            <div class="mb-3">
                <label>Precio</label>
                <input type="number" name="precio" class="form-control" value="<?php echo htmlspecialchars($producto['precio']); ?>" required step="0.01">
            </div>

            <div class="mb-3">
                <label>Stock</label>
                <input type="number" name="stock" class="form-control" value="<?php echo htmlspecialchars($producto['stock']); ?>" required>
            </div>

            <button class="btn btn-success">Actualizar Producto</button>

        </form>

    </div>

</div>

<?php include 'includes/footer.php'; ?>