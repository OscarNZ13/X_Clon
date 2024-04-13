<?php
session_start();
include ('../Db/Connection_db.php');
include_once ('../Model/User_Model.php');
include_once ('../Model/Tweet_Model.php');

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
        <title>Document</title>
        <link href="../Public/css/style.css?v=<?php echo (rand()); ?>" rel="stylesheet">
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
                        <img class="User-pic"
                            src="https://cdn.vectorstock.com/i/preview-1x/77/30/default-avatar-profile-icon-grey-photo-placeholder-vector-17317730.jpg"
                            alt="" srcset="">
                    </div>

                    <p class="Username-p">
                        <?php echo $_SESSION['Usuario']; ?>
                    </p>

                    <button class="Btn-editar-perfil" type="button">
                        <a style="text-decoration: none; color: black" href='../View/profile.php?username=<?php echo $_SESSION['Usuario']; ?>'
                            class="Username-link">Perfil</a>
                    </button>
                </div>

                <div class="Btn-Message-box">
                    <form action="../View/users_page.php" method="post">
                        <button type="submit" class="Btn-Cerrar-Sesion">Usuarios</button>
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
                // Consulta SQL para recuperar los tweets
                $tweetModel = new TweetModel();
                $tweets = $tweetModel->getAllTweets();

                if (!empty($tweets)) {
                    foreach ($tweets as $tweet) {
                        $tweetID = $tweet['ID_Tweet'];
                        $tweetUserID = $tweet['ID_Usuario']; // Obtener el ID del usuario que creó el tweet
                        $tweetContent = $tweet['Contenido'];
                        $tweetDate = $tweet['FechaPublicacion'];
                        $likes = $tweet['Likes'];
                        $retweets = $tweet['Retweets'];

                        // Obtener el nombre de usuario del autor del tweet
                        $tweetAuthor = $userModel->getUserByID($tweetUserID);
                        if ($tweetAuthor) {
                            $tweetUsername = $tweetAuthor['Nombre'];
                        } else {
                            $tweetUsername = "Usuario Desconocido";
                        }

                        // Mostrar el tweet con toda la información
                        echo '<div class="tweet">';
                        echo '<div class="user-info">';
                        echo '<img src="ruta/a/tu/imagen_de_perfil.jpg" alt="Avatar" class="user-avatar">'; // Reemplaza "ruta/a/tu/imagen_de_perfil.jpg" con la ruta de la imagen de perfil del usuario
                        echo '<p class="username">' . $tweetUsername . '</p>'; // Mostrar el nombre del autor del tweet
                        echo '</div>';
                        echo '<p class="tweet-content">' . $tweetContent . '</p>';
                        echo '<div class="tweet-footer">';
                        echo '<span class="tweet-date">' . $tweetDate . '</span>';
                        echo '<p class="tweet-info">Likes: ' . $likes . ' | Retweets: ' . $retweets . '</p>';
                        // Agregar formulario para eliminar el tweet solo si el usuario logeado es el propietario del tweet
                        if ($tweetUserID === $userID) { // Verificar si el usuario logeado es el propietario del tweet
                            echo '<form action="../Controller/tweet_controller.php" method="post">';
                            echo '<input type="hidden" name="tweet_id" value="' . $tweetID . '">';
                            echo '<button type="submit" name="delete_tweet" class="btn-eliminar-tweet">Eliminar</button>';
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