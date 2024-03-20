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
        <form action="../Controller/register_controller.php" method="post">
            <h1 class="h1-2">Registro</h1>

            <p>Email
                <input type="email" placeholder="email..." name="Email" class="input-Email">
            </p>

            <p>Usuario
                <input type="text" placeholder="usua..." name="Usuario" class="input-Username">
            </p>

            <p>Contraseña
                <input type="password" placeholder="contra..." name="Contrasena" class="input-Password">
            </p>

            <p>Ubicacion
                <input type="location" placeholder="ubi..." name="Locacion" class="input-Location">
            </p>

            <button class="Btn-Register-2" type="summit" value="register" name="btn-crear">Crear cuenta</button>

        </form>
    </div>

</body>

</html>