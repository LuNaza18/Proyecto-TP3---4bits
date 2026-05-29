<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sistema Gestión</title>

    <!-- Bootstrap -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <style>

        body{
            background: #26003a;
            color: white;
            overflow-x: hidden;
        }

        /* SIDEBAR */

        .sidebar{
            width: 250px;
            height: 100vh;
            background: #ffc0fb;
            color: black;
            position: fixed;
            padding: 20px;
            font-family: Arial;
            box-shadow: 0 8px 24px rgb(255, 255, 255);
        }

        .sidebar h2{
            margin-bottom: 30px;
        }

        .sidebar a{
            display: block;
            text-decoration: none;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 15px;
            transition: 0.3s;
            color: black;
            font-weight: 700;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 20px;
            box-shadow: 0 8px 24px rgb(146, 6, 64);
        }

        .sidebar a:hover{
            background: #ffd8fa;
        }

        /* CONTENIDO */

        .content{
            margin-left: 270px;
            padding: 20px;
        }

        /* CARDS */

        .card-custom{
            background: #a80695;
            border: none;
            border-radius: 15px;
            color: white;
            box-shadow: 0 8px 24px rgb(217, 25, 115);
        }

        .table-dark th,
        .table-dark td{
            border-color: rgb(0, 0, 0);
            color: black;
            background: #ffc6f0;
        }

        .btn-custom {
            border-radius: 10px;
        }

        .content h1 {
            font-weight: 700;
        }

        .sidebar a.active,
        .sidebar a:hover {
            background: #f1beff;
            color: #000000;
        }

        .sidebar a i {
            margin-right: 10px;
        }

        .content {
            margin-left: 270px;
            padding: 30px;
            min-height: 100vh;
        }

        .form-control,
        .form-select {
            background: #ffffff;
            border: 1px solid #4b5563;
            color: black;
        }

        .form-control:focus,
        .form-select:focus {
            background: #ffffff;
            color: black;
            box-shadow: none;
        }

        .alert {
            background: #b91c1c;
            border: none;
            color: white;
        }

    </style>

</head>

<body>