<?php

include 'includes/conexion.php';

$mensaje = "";

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nombre = mysqli_real_escape_string($conexion, trim($_POST['nombre']));
    $email = mysqli_real_escape_string($conexion, trim($_POST['email']));
    $password = mysqli_real_escape_string($conexion, trim($_POST['password']));

    if($nombre === '' || $email === '' || $password === ''){
        $mensaje = "Por favor completa todos los campos.";
    } else {
        $existe = mysqli_query($conexion, "SELECT id FROM usuarios WHERE email='$email'");
        if(mysqli_num_rows($existe) > 0){
            $mensaje = "El correo ya está registrado.";
        } else {
            mysqli_query($conexion, "INSERT INTO usuarios (nombre, email, password, rol) VALUES ('$nombre', '$email', '$password', 'user')");
            header('Location: login.php');
            exit();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{
            background: #111827;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
        }
        .register-box{
            width: 420px;
            background: #1F2937;
            padding: 30px;
            border-radius: 15px;
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
    <div class="register-box">
        <h2 class="text-center mb-4">Registro de usuario</h2>

        <?php if($mensaje !== ''): ?>
            <div class="alert alert-danger"><?php echo $mensaje; ?></div>
        <?php endif; ?>

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
            <button class="btn btn-primary w-100">Registrarse</button>
        </form>

        <div class="mt-3 text-center">
            <a href="login.php" class="text-white">Ir al login</a>
        </div>
    </div>
</body>
</html>