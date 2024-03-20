<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../Public/css/login.css">
</head>

<body>

    <div class="Login-Box">
        <form action="../Controller/login_controller.php" method="post">
            <h1 class="h1-1">Autenticación</h1>

            <p>Usuario
                <input type="text" placeholder="usua..." name="Usuario" class="input-Username">
            </p>

            <p>Contraseña
                <input type="password" placeholder="contra..." name="Contrasena" class="input-Password">
            </p>

            <button class="Btn-Register-1" type="summit" value="Crear Cuenta"">Crear cuenta</button>
            
            <button class="Btn-Summit" type="summit" value="Ingresar">Ingresar</button>

        </form>
    </div>

</body>

</html>
