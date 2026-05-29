<?php

session_start();

if(!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin'){
    header("Location: login.php");
    exit();
}

include 'includes/conexion.php';

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    header('Location: usuarios.php');
    exit();
}

$id = intval($_GET['id']);
$user = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT * FROM usuarios WHERE id='$id'"));

if(!$user){
    header('Location: usuarios.php');
    exit();
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nombre = mysqli_real_escape_string($conexion, trim($_POST['nombre']));
    $email = mysqli_real_escape_string($conexion, trim($_POST['email']));
    $password = mysqli_real_escape_string($conexion, trim($_POST['password']));
    $rol = mysqli_real_escape_string($conexion, trim($_POST['rol']));

    $passwordSql = $password !== '' ? ", password='$password'" : '';
    mysqli_query($conexion, "UPDATE usuarios SET nombre='$nombre', email='$email', rol='$rol' $passwordSql WHERE id='$id'");

    header('Location: usuarios.php');
    exit();
}

include 'includes/header.php';
include 'includes/sidebar.php';
?>

<div class="content">
    <h1 class="mb-4">Editar usuario</h1>
    <div class="card card-custom p-4">
        <form method="POST">
            <div class="mb-3">
                <label>Nombre</label>
                <input type="text" name="nombre" class="form-control" value="<?php echo htmlspecialchars($user['nombre']); ?>" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="mb-3">
                <label>Contraseña <small>(dejar en blanco para no cambiar)</small></label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="mb-3">
                <label>Rol</label>
                <select name="rol" class="form-control" required>
                    <option value="user" <?php echo $user['rol'] === 'user' ? 'selected' : ''; ?>>Usuario</option>
                    <option value="admin" <?php echo $user['rol'] === 'admin' ? 'selected' : ''; ?>>Administrador</option>
                    <option value="vendedor" <?php echo $user['rol'] === 'vendedor' ? 'selected' : ''; ?>>Vendedor</option>
                    <option value="repartidor" <?php echo $user['rol'] === 'repartidor' ? 'selected' : ''; ?>>Repartidor</option>
                </select>
            </div>
            <button class="btn btn-success">Guardar cambios</button>
            <a href="usuarios.php" class="btn btn-secondary btn-custom">Cancelar</a>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>