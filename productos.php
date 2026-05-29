<?php

session_start();

if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
    exit();
}

if(!in_array($_SESSION['rol'], ['admin', 'vendedor'])){
    header("Location: index.php");
    exit();
}

include 'includes/conexion.php';

if(isset($_GET['eliminar']) && is_numeric($_GET['eliminar'])){
    $id = intval($_GET['eliminar']);
    mysqli_query($conexion, "DELETE FROM productos WHERE id='$id'");
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
        "INSERT INTO productos (nombre, descripcion, precio, stock) VALUES ('$nombre', '$descripcion', '$precio', '$stock')"
    );

    header("Location: productos.php");
    exit();
}

$productos = mysqli_query($conexion, "SELECT * FROM productos");

?>

<?php include 'includes/header.php'; ?>

<?php include 'includes/sidebar.php'; ?>

<div class="content">

    <h1 class="mb-4">Productos</h1>

    <div class="card card-custom p-4">
        <form method="POST">
            <div class="mb-3">
                <label>Nombre</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Descripción</label>
                <textarea name="descripcion" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <label>Precio</label>
                <input type="number" name="precio" class="form-control" required step="0.01">
            </div>
            <div class="mb-3">
                <label>Stock</label>
                <input type="number" name="stock" class="form-control" required>
            </div>
            <button class="btn btn-primary">Guardar Producto</button>
        </form>
    </div>

    <div class="card card-custom p-4 mt-4">
        <h4 class="mb-3">Lista de Productos</h4>
        <table class="table table-dark table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while($producto = mysqli_fetch_assoc($productos)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($producto['id']); ?></td>
                        <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                        <td>$<?php echo htmlspecialchars($producto['precio']); ?></td>
                        <td><?php echo htmlspecialchars($producto['stock']); ?></td>
                        <td>
                            <a href="ver_producto.php?id=<?php echo $producto['id']; ?>" class="btn btn-info btn-sm btn-custom">Consultar</a>
                            <a href="editar_producto.php?id=<?php echo $producto['id']; ?>" class="btn btn-warning btn-sm btn-custom">Modificar</a>
                            <a href="productos.php?eliminar=<?php echo $producto['id']; ?>" class="btn btn-danger btn-sm btn-custom" onclick="return confirm('¿Eliminar producto?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</div>

<?php include 'includes/footer.php'; ?>