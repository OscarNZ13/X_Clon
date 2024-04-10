<?php
session_start();
include('../Db/Connection_db.php');
include('../Model/User_Model.php');

if (isset($_SESSION['Usuario'])) {
    $username = $_SESSION['Usuario'];
}

$Usuario = new UserModel();

$Datos_Usuario = $Usuario->getUserByUsername($username);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>X</title>
    <link rel="stylesheet" href="../Public/css/UserProfile_style.css">
</head>

<body>

    <div class="UserProfile-Box">


        <div class="User-info">
            <div class="img-user">
                <img src="<?php echo $Datos_Usuario['CorreoElectronico']; ?>" alt="ImgUsuario" srcset="" class="div-img-usuario">
            </div>

            <h1><?php echo $Datos_Usuario['Nombre']; ?></h1>
            <p>Correo: <?php echo $Datos_Usuario['CorreoElectronico']; ?></p>
            <p>Descripción: <?php echo $Datos_Usuario['Biografia']; ?></p>
            <p>Ubicación: <?php echo $Datos_Usuario['Ubicacion']; ?></p>

            <form action="" method="POST">
                <button type="submit" name="seguir_usuario" class="seguir_usuario-btn">
                    Seguir
                </button>
            </form>
            <a href="../View/home_page.php">
                <img src="../Public/img/back_icon.png" alt="" class="img-atras-perfil">
            </a>
        </div>

        <div class="Tweet-box">

        </div>

    </div>

</body>

</html>