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
        <title>X</title>
        <link href="../Public/css/style.css" rel="stylesheet">
        <link href="../Public/css/style_tweet.css" rel="stylesheet">
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
                        <img class="User-pic" src="https://cdn.vectorstock.com/i/preview-1x/77/30/default-avatar-profile-icon-grey-photo-placeholder-vector-17317730.jpg" alt="" srcset="">
                    </div>

                    <p class="Username-p">
                        <?php echo $_SESSION['Usuario']; ?>
                    </p>

                    <button class="Btn-editar-perfil" type="button">
                        <a href="../view/user_profile.php" class="Username-link">Editar</a>
                    </button>
                </div>

                <div class="Btn-Message-box">
                    <form action="../Controller/logout_controller.php" method="post">
                        <button type="submit" class="Btn-Cerrar-Sesion">Cerrar Sesión</button>
                    </form>
                </div>

            </div>

            <div class="header">
                <div class="modo-feed-box">
                    <button type="button" class="Btn-todo">
                        Siguiendo
                    </button>
                    <button type="button" class="Btn-siguiendo">
                        Para ti
                    </button>
                </div>

                <div class="Barra-busqueda-box">
                    <input type="text" class="search-input" placeholder="Buscar...">
                    <button class="search-button"></button>
                </div>

                <!-- Formulario para escribir un nuevo tweet -->
                <div class="Nuevo-post-box">
                    <form action="../Controller/tweet_controller.php" method="post" class="tweet-form">
                        <textarea name="contenido" placeholder="Escribe tu tweet aquí" required></textarea>
                        <button type="submit">Enviar</button>
                    </form>
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
                        echo '<div class="tweet">';
                        echo '<div class="user-info">';
                        echo '<img src="ruta/a/tu/imagen_de_perfil.jpg" alt="Avatar" class="user-avatar">'; // Reemplaza "ruta/a/tu/imagen_de_perfil.jpg" con la ruta de la imagen de perfil del usuario
                        echo '<p class="username">' . $UserName . '</p>';
                        echo '</div>';
                        echo '<div class="tweet-footer">';
                        // Agregar formulario para eliminar el tweet
                        if ($UserID_Mostrado != $userID) {
                            echo '<form action="../Controller/users_page_controller.php" method="post">';
                            echo '<input type="hidden" name="user_id_f" value="' . $UserID_Mostrado . '">';
                            echo '<input type="hidden" name="user_id_l" value="' . $userID . '">';
                            echo '<button type="submit" name="btn-seguir">Seguir</button>';
                            echo '</form>';
                        }
                        
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo "No hay tweets disponibles.";
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