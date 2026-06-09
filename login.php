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
    <title>Login - 4Bits</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body{
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            font-family: Arial, sans-serif;
        }

        #video-fondo{
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -2;
        }

        body::before{
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.65);
            z-index: -1;
        }
        .login-box{
    width: 450px;
    padding: 40px;
    border-radius: 25px;
    background: rgba(17, 24, 39, 0.75);
    backdrop-filter: blur(15px);
    border: 2px solid rgba(236,72,153,.4);
    box-shadow:
        0 0 20px rgba(236,72,153,.4),
        0 0 50px rgba(139,92,246,.3);
    color: white;
}

.contenedor-logo{
    text-align: center;
    margin-bottom: 25px;
}

.logo-titulo{
    font-size: 4rem;
    font-weight: 900;
    letter-spacing: 4px;
    margin-bottom: 5px;

    background: linear-gradient(
        90deg,
        #A855F7,
        #EC4899
    );

    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.logo-subtitulo{
    color: #E9D5FF;
    letter-spacing: 2px;
    font-size: .95rem;
}

.contenedor-logo::after{
    content: "";
    display: block;
    width: 140px;
    height: 3px;
    margin: 15px auto 0;

    background: linear-gradient(
        90deg,
        #8B5CF6,
        #EC4899
    );

    border-radius: 20px;
}

.form-control{
    background: rgba(255,255,255,.08);
    border: 1px solid #8B5CF6;
    color: white;
}

.form-control:focus{
    background: rgba(255,255,255,.12);
    border-color: #EC4899;
    color: white;
    box-shadow: 0 0 10px rgba(236,72,153,.5);
}

.btn-primary{
    border: none;
    border-radius: 12px;
    font-weight: bold;
    background: linear-gradient(
        135deg,
        #8B5CF6,
        #EC4899
    );
}

.btn-primary:hover{
    background: linear-gradient(
        135deg,
        #A855F7,
        #F472B6
    );
}

.text-info{
    color: #F472B6 !important;
}
    </style>
</head>
<body>

    <video autoplay muted loop id="video-fondo">
        <source src="imagenes/4417-179384231.mp4" type="video/mp4">
    </video>

    <div class="login-box">

        <div class="contenedor-logo">
            <h1 class="logo-titulo">4Bits</h1>
            <p class="logo-subtitulo">
                Gaming • Tecnología • Innovación
            </p>
        </div>

        <h2 class="text-center mb-4">Iniciar Sesión</h2>

        <?php if($mensaje !== ""): ?>
            <div class="alert alert-danger">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <form method="POST">

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input
                    type="email"
                    name="email"
                    class="form-control"
                    autocomplete= "off";
                    required
                >
            </div>

            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input
                    type="password"
                    name="password"
                    class="form-control"
                    autocomplete="new-password"
                    required
                >
            </div>

            <button type="submit" class="btn btn-primary w-100">
                Ingresar
            </button>

        </form>

        <div class="mt-3 text-center">
            <span class="text-white">
                ¿No tienes cuenta?
            </span>
            <a href="registro.php" class="text-info">
                Regístrate aquí
            </a>
        </div>

    </div>

</body>
</html>