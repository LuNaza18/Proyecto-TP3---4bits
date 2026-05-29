<?php

session_start();

if(!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin'){
    header("Location: login.php");
    exit();
}

include 'includes/conexion.php';
include 'includes/header.php';
include 'includes/sidebar.php';

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
?>

<div class="content">
    <h1 class="mb-4">Usuario: <?php echo htmlspecialchars($user['nombre']); ?></h1>
    <div class="card card-custom p-4">
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <p><strong>Rol:</strong> <?php echo htmlspecialchars($user['rol']); ?></p>
        <p><strong>ID:</strong> <?php echo htmlspecialchars($user['id']); ?></p>
        <div class="d-flex gap-2">
            <a href="editar_usuario.php?id=<?php echo $user['id']; ?>" class="btn btn-warning btn-sm btn-custom">Modificar</a>
            <a href="usuarios.php" class="btn btn-secondary btn-sm btn-custom">Volver</a>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>