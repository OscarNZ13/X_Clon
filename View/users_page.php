<?php
session_start();
include('../Db/Connection_db.php');
include_once('../Model/User_Model.php');
include_once('../Model/Tweet_Model.php');

if (isset($_SESSION['Usuario'])) {
    $username = $_SESSION['Usuario'];
    $userModel = new UserModel();
    $user = $userModel->getUserByUsername($username);
    $userID = $user['ID_Usuario']; // Obtener el ID_Usuario del usuario logueado
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Usuarios</title>
        <link rel="icon" href="../Public/img/X_logo.png" type="image/x-icon">
        <link href="../Public/css/style_users_page.css?php echo (rand()); ?>" rel="stylesheet">
        <link href="../Public/css/style_tweet.css?v=<?php echo (rand()); ?>" rel="stylesheet">
    </head>

    <body>
        <section class="layout">

            <div class="aside">
                <div class="Logo-box">
                    <a href="../View/home_page.php">
                        <img class="Logo-X" src="../Public/img/X_logo.png" alt="Logo X">
                    </a>
                </div>

                <div class="Perfil-box">
                    <div class="Perfil-img">
                        <?php
                        $profilePic = $user['FotoPerfil']; // Obtener la URL de la imagen de perfil desde la base de datos
                    
                        // Si la URL de la imagen está vacía, usar la imagen predeterminada
                        if (empty($profilePic)) {
                            $profilePic = 'https://cdn.vectorstock.com/i/preview-1x/77/30/default-avatar-profile-icon-grey-photo-placeholder-vector-17317730.jpg';
                        }
                        ?>
                        <img class="User-pic" src="<?php echo $profilePic; ?>" alt="Foto de perfil" srcset="">
                    </div>

                    <p class="Username-p">
                        <?php echo $_SESSION['Usuario']; ?>
                    </p>

                    <button class="Btn-editar-perfil" type="button">
                        <a style="text-decoration: none; color: black" href='../View/profile.php?username=<?php echo $_SESSION['Usuario']; ?>'
                            class="Username-link">Perfil</a>
                    </button>
                </div>

            </div>

            <div class="main">
                <?php
                // Consulta SQL para recuperar todos los usuarios
                $userModel_2 = new UserModel();
                $Users = $userModel_2->getAllUsers();

                if (!empty($Users)) {
                    foreach ($Users as $User) {
                        $UserID_Mostrado = $User['ID_Usuario'];
                        $UserName = $User['Nombre'];
                        $UserPhoto = $User['FotoPerfil'];

                        // Mostrar los usuarios
                ?>
                        <div class="tweet">
                            <div class="user-info">
                                <img src="<?php echo $UserPhoto; ?>" alt="Avatar" class="user-avatar">
                                <a href="../View/profile.php?username=<?= $UserName ?>" class="username"><?= $UserName ?></a>
                            </div>
                            <div class="tweet-footer">
                                <?php
                                // Agregar formulario para seguir o dejar de seguir al usuario
                                if ($UserID_Mostrado != $userID) {
                                    $userModel = new UserModel();
                                    $sigueUsuario = $userModel->verificarSiUsuarioSigue($userID, $UserID_Mostrado);
                                ?>
                                    <form action="../Controller/users_page_controller.php" method="post">
                                        <input type="hidden" name="user_id_f" value="<?= $UserID_Mostrado ?>">
                                        <input type="hidden" name="user_id_l" value="<?= $userID ?>">
                                        <button type="submit" name="btn-seguir" class="<?= $sigueUsuario ? 'btn-seguir' : 'btn-dejar-de-seguir' ?>">
                                            <?= $sigueUsuario ? 'Siguiendo' : 'Seguir' ?>
                                        </button>
                                    </form>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo "No hay usuarios disponibles.";
                }
                ?>
            </div>

        </section>
    </body>

    </html>

<?php
} else {
    header("Location: ../View/index.php");
    exit();
}
?>