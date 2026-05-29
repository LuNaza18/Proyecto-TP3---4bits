<?php

session_start();

if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
    exit();
}

if($_SESSION['rol'] !== 'admin'){
    header("Location: index.php");
    exit();
}

include 'includes/conexion.php';

if(isset($_GET['eliminar']) && is_numeric($_GET['eliminar'])){
    $id = intval($_GET['eliminar']);
    mysqli_query($conexion, "DELETE FROM usuarios WHERE id='$id'");
    header("Location: usuarios.php");
    exit();
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nombre = mysqli_real_escape_string($conexion, trim($_POST['nombre']));
    $email = mysqli_real_escape_string($conexion, trim($_POST['email']));
    $password = mysqli_real_escape_string($conexion, trim($_POST['password']));
    $rol = mysqli_real_escape_string($conexion, trim($_POST['rol']));

    mysqli_query(
        $conexion,
        "INSERT INTO usuarios (nombre, email, password, rol) VALUES ('$nombre', '$email', '$password', '$rol')"
    );

    header("Location: usuarios.php");
    exit();
}

$usuarios = mysqli_query($conexion, "SELECT * FROM usuarios");

?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="content">

    <h1 class="mb-4">Usuarios</h1>

    <div class="card card-custom p-4 mb-4">
        <h4>Crear usuario</h4>
        <form method="POST">
            <div class="mb-3">
                <label>Nombre</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Contraseña</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Rol</label>
                <select name="rol" class="form-control" required>
                    <option value="user">Usuario</option>
                    <option value="admin">Administrador</option>
                    <option value="vendedor">Vendedor</option>
                    <option value="repartidor">Repartidor</option>
                </select>
            </div>
            <button class="btn btn-primary">Crear usuario</button>
        </form>
    </div>

    <div class="card card-custom p-4">
        <h4 class="mb-3">Lista de usuarios</h4>
        <table class="table table-dark table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while($usuario = mysqli_fetch_assoc($usuarios)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($usuario['id']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['rol']); ?></td>
                        <td>
                            <a href="ver_usuario.php?id=<?php echo $usuario['id']; ?>" class="btn btn-info btn-sm btn-custom">Consultar</a>
                            <a href="editar_usuario.php?id=<?php echo $usuario['id']; ?>" class="btn btn-warning btn-sm btn-custom">Modificar</a>
                            <a href="usuarios.php?eliminar=<?php echo $usuario['id']; ?>" class="btn btn-danger btn-sm btn-custom" onclick="return confirm('¿Eliminar usuario?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</div>

<?php include 'includes/footer.php'; ?>