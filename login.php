<?php

session_start();

include 'includes/conexion.php';

$mensaje = "";

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = mysqli_real_escape_string($conexion, trim($_POST['email']));
    $password = mysqli_real_escape_string($conexion, trim($_POST['password']));

    $consulta = mysqli_query(
        $conexion,
        "SELECT * FROM usuarios WHERE email='$email' AND password='$password'"
    );

    if(mysqli_num_rows($consulta) > 0){
        $usuario = mysqli_fetch_assoc($consulta);
        $_SESSION['user_id'] = $usuario['id'];
        $_SESSION['usuario'] = $usuario['nombre'];
        $_SESSION['email'] = $usuario['email'];
        $_SESSION['rol'] = $usuario['rol'];

        if($usuario['rol'] === 'user'){
            header("Location: tienda.php");
        } else {
            header("Location: index.php");
        }
        exit();
    } else {
        $mensaje = "❌ Datos incorrectos";
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{
            background: #111827;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box{
            width: 400px;
            background: #1F2937;
            padding: 30px;
            border-radius: 15px;
            color: white;
        }

        .form-control{
            background: #374151;
            border: none;
            color: white;
        }

        .form-control:focus{
            background: #374151;
            color: white;
            box-shadow: none;
        }
    </style>

</head>
<body>

<div class="login-box">
    <h2 class="text-center mb-4">Iniciar Sesión</h2>

    <?php if($mensaje !== ""): ?>
        <div class="alert alert-danger"><?php echo $mensaje; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Contraseña</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button class="btn btn-primary w-100">Ingresar</button>
    </form>

    <div class="mt-3 text-center">
        <span class="text-white">¿No tienes cuenta?</span>
        <a href="registro.php" class="text-info">Regístrate aquí</a>
    </div>
</div>

</body>
</html>