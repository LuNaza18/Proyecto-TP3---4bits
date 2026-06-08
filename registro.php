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
       *{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    overflow:hidden;
    font-family:'Segoe UI',sans-serif;
}

#video-fondo{
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    object-fit:cover;
    z-index:-2;
}

body::before{
    content:"";
    position:fixed;
    inset:0;
    background:rgba(10,10,20,.75);
    z-index:-1;
}

.register-box{
    width:480px;
    padding:40px;
    border-radius:25px;

    background:rgba(17,24,39,.75);
    backdrop-filter:blur(15px);

    border:2px solid rgba(236,72,153,.4);

    box-shadow:
        0 0 20px rgba(236,72,153,.4),
        0 0 50px rgba(139,92,246,.3);

    color:white;
}

.contenedor-logo{
    text-align:center;
    margin-bottom:25px;
}

.icono-registro{
    font-size:3rem;
    margin-bottom:10px;
}

.logo-titulo{
    font-size:4rem;
    font-weight:900;
    letter-spacing:4px;

    background:linear-gradient(
        90deg,
        #A855F7,
        #EC4899
    );

    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
}

.logo-subtitulo{
    color:#E9D5FF;
    margin-top:10px;
    letter-spacing:1px;
}

.contenedor-logo::after{
    content:"";
    display:block;
    width:140px;
    height:3px;
    margin:15px auto 0;

    background:linear-gradient(
        90deg,
        #8B5CF6,
        #EC4899
    );

    border-radius:20px;
}

.form-control{
    background:rgba(255,255,255,.08);
    border:1px solid #8B5CF6;
    color:white;
}

.form-control:focus{
    background:rgba(255,255,255,.12);
    color:white;
    border-color:#EC4899;

    box-shadow:
        0 0 10px rgba(236,72,153,.5);
}

.btn-primary{
    border:none;
    border-radius:12px;
    padding:12px;

    font-weight:bold;

    background:linear-gradient(
        135deg,
        #8B5CF6,
        #EC4899
    );
}

.btn-primary:hover{
    background:linear-gradient(
        135deg,
        #A855F7,
        #F472B6
    );
}

.text-info{
    color:#F472B6 !important;
    text-decoration:none;
}
    </style>
</head>
<body>

    <video autoplay muted loop id="video-fondo">
        <source src="imagenes/4417-179384231.mp4" type="video/mp4">
    </video>

    <div class="register-box">

        <div class="contenedor-logo">

           

            <h1 class="logo-titulo">4Bits</h1>

            <p class="logo-subtitulo">
                Crea tu cuenta y comienza a comprar
            </p>

        </div>

        

        <?php if($mensaje !== ''): ?>
            <div class="alert alert-danger">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <form method="POST" autocomplete="off">

            <div class="mb-3">
                <label class="form-label">Nombre completo</label>
                <input
                    type="text"
                    name="nombre"
                    class="form-control"
                    autocomplete="off"
                    required
                >
            </div>

            <div class="mb-3">
                <label class="form-label">Correo electrónico</label>
                <input
                    type="email"
                    name="email"
                    class="form-control"
                    autocomplete="off"
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

            <button class="btn btn-primary w-100">
                Crear Cuenta
            </button>

        </form>

        <div class="mt-4 text-center">
            <span>¿Ya tienes cuenta?</span>
            <a href="login.php" class="text-info">
                Inicia sesión
            </a>
        </div>

    </div>

</body>
</html>