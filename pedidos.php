<?php

session_start();

if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
    exit();
}

if(!in_array($_SESSION['rol'], ['admin', 'vendedor', 'repartidor'])){
    header("Location: index.php");
    exit();
}

include 'includes/conexion.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'
   && isset($_POST['pedido_id'])
   && is_numeric($_POST['pedido_id'])){

    $pedido_id = intval($_POST['pedido_id']);
    $nuevo_estado = $_POST['nuevo_estado'];

    $estados_validos = [
        'pendiente',
        'en_camino',
        'entregado'
    ];

    if(in_array($nuevo_estado, $estados_validos)){

        mysqli_query(
            $conexion,
            "UPDATE pedidos
             SET estado='$nuevo_estado'
             WHERE id='$pedido_id'"
        );

        header("Location: pedidos.php");
        exit();
    }
}

include 'includes/header.php';
include 'includes/sidebar.php';

$pedidos = [];

$query = "

SELECT

    p.id,
    p.total,
    p.estado,
    p.fecha,
    u.nombre AS usuario

FROM pedidos p

LEFT JOIN usuarios u
ON u.id = p.usuario_id

ORDER BY p.id DESC

";

$resultado = mysqli_query($conexion, $query);

while($pedido = mysqli_fetch_assoc($resultado)){

    $pedidos[] = $pedido;

}

?>

<div class="content">

    <h1 class="mb-4">

        Pedidos

    </h1>

    <div class="card card-custom p-4">

        <table class="table table-dark table-hover">

            <thead>

                <tr>

                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Acciones</th>

                </tr>

            </thead>

            <tbody>

                <?php foreach($pedidos as $pedido){ ?>

                    <tr>

                        <td>

                            <?php echo $pedido['id']; ?>

                        </td>

                        <td>

                            <?php echo $pedido['usuario']; ?>

                        </td>

                        <td>

                            $<?php echo number_format($pedido['total'],2,',','.'); ?>

                        </td>

                        <td>

                            <?php echo ucfirst($pedido['estado']); ?>

                        </td>

                        <td>

                            <?php echo $pedido['fecha']; ?>

                        </td>

                        <td>

                            <?php if($pedido['estado'] != 'entregado'){ ?>

                                <form method="POST">

                                    <input
                                        type="hidden"
                                        name="pedido_id"
                                        value="<?php echo $pedido['id']; ?>"
                                    >

                                    <select
                                        name="nuevo_estado"
                                        class="form-select form-select-sm mb-2"
                                    >

                                        <option value="pendiente">
                                            Pendiente
                                        </option>

                                        <option value="en_camino">
                                            En camino
                                        </option>

                                        <option value="entregado">
                                            Entregado
                                        </option>

                                    </select>

                                    <button
                                        class="btn btn-success btn-sm"
                                    >

                                        Actualizar

                                    </button>

                                </form>

                            <?php }else{ ?>

                                <span class="badge bg-success">

                                    Entregado

                                </span>

                            <?php } ?>

                        </td>

                    </tr>

                <?php } ?>

            </tbody>

        </table>

    </div>

</div>

<?php include 'includes/footer.php'; ?>