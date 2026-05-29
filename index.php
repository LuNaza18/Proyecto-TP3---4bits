<?php
session_start();

if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
    exit();
}

include 'includes/conexion.php';

function safeCount($conexion, $table){
    $table = preg_replace('/[^a-zA-Z0-9_]/', '', $table);
    try {
        $result = mysqli_query($conexion, "SELECT COUNT(*) AS total FROM `$table`");
        if(!$result){
            return 0;
        }
        return intval(mysqli_fetch_assoc($result)['total']);
    } catch (Throwable $e) {
        return 0;
    }
}

$role = $_SESSION['rol'];
$productos_count = safeCount($conexion, 'productos');
$usuarios_count = safeCount($conexion, 'usuarios');
$pedidos_count = safeCount($conexion, 'pedidos');

try {
    $ventas_result = mysqli_query($conexion, "SELECT COALESCE(SUM(precio * stock), 0) AS total FROM productos");
    $ventas_total = $ventas_result ? number_format(floatval(mysqli_fetch_assoc($ventas_result)['total']), 2) : "0.00";
} catch (Throwable $e) {
    $ventas_total = "0.00";
}

?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="content">

    <div class="mb-4">

        <h1 style="color:white;">

            Bienvenido <?php echo htmlspecialchars($_SESSION['usuario']); ?>

        </h1>

        <p style="color:#9CA3AF; font-size:18px;">

            Rol: <?php echo htmlspecialchars($_SESSION['rol']); ?>

        </p>

    </div>

    <div class="row">
        <?php if($role === 'admin'): ?>
            <div class="col-md-3 mb-3">
                <div class="card card-custom p-3">
                    <h5>Productos</h5>
                    <h2><?php echo $productos_count; ?></h2>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card card-custom p-3">
                    <h5>Pedidos</h5>
                    <h2><?php echo $pedidos_count; ?></h2>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card card-custom p-3">
                    <h5>Usuarios</h5>
                    <h2><?php echo $usuarios_count; ?></h2>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card card-custom p-3">
                    <h5>Ventas (estimado)</h5>
                    <h2>$<?php echo $ventas_total; ?></h2>
                </div>
            </div>
        <?php elseif($role === 'vendedor'): ?>
            <div class="col-md-4 mb-3">
                <div class="card card-custom p-3">
                    <h5>Productos</h5>
                    <h2><?php echo $productos_count; ?></h2>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card card-custom p-3">
                    <h5>Pedidos</h5>
                    <h2><?php echo $pedidos_count; ?></h2>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card card-custom p-3">
                    <h5>Tienda</h5>
                    <h2>Ver catálogo</h2>
                </div>
            </div>
        <?php elseif($role === 'repartidor'): ?>
            <div class="col-md-6 mb-3">
                <div class="card card-custom p-3">
                    <h5>Pedidos</h5>
                    <h2><?php echo $pedidos_count; ?></h2>
                </div>
            </div>
        <?php else: ?>
            <div class="col-md-6 mb-3">
                <div class="card card-custom p-3">
                    <h5>Tienda</h5>
                    <h2><?php echo $productos_count; ?> productos</h2>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card card-custom p-3">
                    <h5>Pedidos</h5>
                    <h2><?php echo $pedidos_count; ?></h2>
                </div>
            </div>
        <?php endif; ?>
    </div>

</div>

<?php include 'includes/footer.php'; ?>