<?php
session_start();
include_once ('../Db/Connection_db.php');
include_once ('../Model/User_Model.php');
include_once ('../Model/Tweet_Model.php');

if (isset($_SESSION['Usuario'])) {
    $username = $_SESSION['Usuario'];
    $userModel = new UserModel();
    $user = $userModel->getUserByUsername($username);
    $userID = $user['ID_Usuario']; // Obtener el ID_Usuario del usuario logeado
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Siguiendo</title>
        <link rel="icon" href="../Public/img/X_logo.png" type="image/x-icon">
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
                        <a style="text-decoration: none; color: black"
                            href='../View/profile.php?username=<?php echo $_SESSION['Usuario']; ?>'
                            class="Username-link">Perfil</a>
                    </button>
                </div>

                <div class="Btn-Message-box">
                    <form action="../View/users_page.php" method="post">
                        <button type="submit" class="Btn-Users-Page">Usuarios</button>
                    </form>
                </div>

            </div>

            <div class="header">
                <div class="modo-feed-box">
                    <button type="button" class="Btn-todo">
                        <a style="text-decoration: none; color: black" href='../View/feed_followed.php'>Siguiendo</a>
                    </button>
                    <button type="button" class="Btn-siguiendo">
                        <a style="text-decoration: none; color: black" href='../View/home_page.php'>Para ti</a>
                    </button>
                </div>

                <!-- Formulario para escribir un nuevo tweet -->
                <div class="Nuevo-post-box">
                    <form action="../Controller/tweet_controller.php" method="post" class="tweet-form">
                        <textarea class="box-tex-tweet" name="contenido" placeholder="Escribe tu tweet aquí"
                            required></textarea>
                        <button type="submit" class="Btn-Agregar-Tweet">Enviar</button>
                    </form>
                </div>
            </div>

            <div class="main">
                <?php
                // Obtener los IDs de los usuarios seguidos por el usuario logeado
                $followedUsersIDs = $userModel->getFollowedUsersIDs($userID);

                // Obtener los tweets de los usuarios seguidos
                $tweetModel = new TweetModel();
                $tweets = $tweetModel->getTweetsFromFollowedUsers($followedUsersIDs);

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
                            $tweetUserProfilePic = $tweetAuthor['FotoPerfil'];
                        } else {
                            $tweetUsername = "Usuario Desconocido";
                            $tweetUserProfilePic = "ruta/a/tu/imagen_de_perfil.jpg";
                        }

                        // Mostrar el tweet con toda la información
                        echo '<div class="tweet">';
                        echo '<div class="user-info">';
                        echo '<img src="' . $tweetUserProfilePic . '" alt="Avatar" class="user-avatar">'; // Utilizar la ruta de la imagen de perfil del autor del tweet
                        echo '<p class="username"><a href="../View/profile.php?username=' . $tweetUsername . '">' . $tweetUsername . '</a></p>'; // Mostrar el nombre del autor del tweet como un enlace al perfil del usuario
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
                    echo "No hay tweets disponibles de los usuarios que sigues.";
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