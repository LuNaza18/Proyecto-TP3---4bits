<?php

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$conexion = mysqli_connect(
    "localhost",
    "root",
    "",
    "gestion_general"
);

if(!$conexion){
    die("Error de conexión: " . mysqli_connect_error());
}

mysqli_set_charset($conexion, 'utf8');
if(isset($_GET['eliminar'])){

    $id = $_GET['eliminar'];

    mysqli_query(

        $conexion,

        "DELETE FROM productos
        WHERE id='$id'"

    );

}