<?php
session_start();
if(!isset($_SESSION['usuario'])){
    header('Location: ../login.php');
    exit();
}
include '../includes/header.php';
include '../includes/sidebar.php';
?>
<div class="content">
    <h1>Usuarios Admin</h1>
    <p>Esta sección está en construcción.</p>
</div>
<?php include '../includes/footer.php'; ?>