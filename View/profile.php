<?php
session_start();
include ('../Db/Connection_db.php');
include ('../Controller/profile_controller.php');
include_once ('../Model/User_Model.php');
include_once ('../Model/Tweet_Model.php');

if (isset($_SESSION['Usuario'])) {
    $username = isset($_GET['username']) ? $_GET['username'] : '';
    if ($username) {
        $userModel_P = new UserModel();
        $user = $userModel_P->getUserByUsername($username);
        $userID_P = $user['ID_Usuario']; // Obtener el ID_Usuario del usuario del perfil

        if ($user) {
            // Continuar mostrando el perfil del usuario
        } else {
            // Manejar el caso en que el usuario no existe
            header("location: ../View/profile.php");
            exit();
        }
    } else {
        // Manejar el caso en que no se proporcionó un nombre de usuario en la URL
        header("location: ../View/profile.php");
        exit();
    }

    ?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Mi Perfil</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="../Public/css/styles.css?v=<?php echo (rand()); ?>">
        <link rel="stylesheet" href="../Public/css/sidebar.css?v=<?php echo (rand()); ?>">
        <script src="../Public/js/profile_script.js?v=<?php echo (rand()); ?>"></script>
    </head>

    <body>
        <div class="container">
            <div class="grid-container">
                <div class="sidebar">
                    <ul style="list-style:none;">
                        <li><i class="fa fa-twitter" style="color:#50b7f5;font-size:10px;"></i></li>

                        <li class="active_menu"><a href='../View/home_page.php'><i class="fa fa-home"
                                    style="color:#50b7f5;"></i><span style="color:#50b7f5;">Home</span></a></li>

                        <li><a href='#'><i class="fa fa-hashtag"></i><span>Explorar</span></a></li>

                        <li><a href="#"><i class="fa fa-bell" aria-hidden="true"></i><span>Notificaciones</span>

                        <li id='messagePopup'><a><i class="fa fa-envelope" aria-hidden='true'></i><span>Mensajes</span>

                        <li><a href='../View/profile.php?username=<?php echo $_SESSION['Usuario']; ?>'
                                class="Username-link"><i class="fa fa-user"></i> Perfil</a></li>

                        <?php if (isset($_SESSION['Usuario']) == $username) { ?>
                            <li><a href='../View/profile_edit.php'><i class="fa fa-cog"></i><span>Editar Perfil</span></a></li>

                            <li>
                                <form action="../Controller/logout_controller.php" method="post">
                                    <button type="submit" class="logout-btn">
                                        <i class="fa fa-power-off"></i>
                                        <span>Cerrar Sesión</span>
                                    </button>
                                </form>
                            </li>

                            <li id='tweetButton'><button class="sidebar_tweet button addTweetBtn"
                                    style="outline:none;">Tweet</button></li>

                            <li id="tweetBox" style="display:none;">
                                <form action="../Controller/tweet_controller.php" method="post" class="tweet-form">
                                    <textarea class="box-tex-tweet" name="contenido" placeholder="Escribe tu tweet aquí"
                                        required></textarea>
                                    <button type="submit" class="Btn-Agregar-Tweet">Enviar</button>
                                </form>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="main">
                    <div class="profile">
                        <?php if ($user): ?>
                            <div class="profile-info">
                                <img src="<?php echo $user['FotoPerfil']; ?>" alt="Foto de perfil">
                                <h1><?php echo $user['Nombre']; ?></h1>
                                <p>Descripción: <?php echo $user['Biografia']; ?></p>
                                <p>Ubicación: <?php echo $user['Ubicacion']; ?></p>
                                <?php if (isset($_SESSION['Usuario']) != $username) { ?>
                                    <form action="" method="POST">
                                        <button type="submit" name="follow" class="leave-btn">Seguir</button>
                                    </form>
                                <?php } ?>
                            </div>
                            <div class="tweets">
                                <h2>Mis Tweets</h2>
                                <br>
                                <?php
                                // Consulta SQL para recuperar los tweets
                                $tweetModel_P = new TweetModel();
                                $tweets = $tweetModel_P->getTweetsForUser($userID_P);

                                foreach ($tweets as $tweet):
                                    $tweetID = $tweet['ID_Tweet'];
                                    $tweetUserID_P = $tweet['ID_Usuario']; ?>

                                    <div class="tweet">
                                        <p><?php echo $tweet['Contenido']; ?></p>
                                        <span><?php echo $tweet['FechaPublicacion']; ?></span>
                                        <div class="tweet-actions">

                                            <?php if ($tweetUserID_P === $userID_P) { // Verificar si el usuario logeado es el propietario del tweet
                                                                echo '<form action="../Controller/tweet_controller.php" method="post">';
                                                                echo '<input type="hidden" name="tweet_id" value="' . $tweetID . '">';
                                                                echo '<button type="submit" name="delete_tweet">Eliminar</button>';
                                                                echo '</form>';
                                                            }
                                                            ?>
                                            <button class="like-btn likes-count"> <?php echo $tweet['Likes']; ?> Like</button>
                                            <button class="comment-btn comments-count"><?php echo $tweet['Retweets']; ?>
                                                Comentar</button>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="right_sidebar">
                    <h2>Tendencias</h2>
                    <!-- Aquí puedes incluir contenido dinámico de tendencias -->
                    <div class="trend">
                        <p>#ElonMusk</p>
                    </div>
                    <div class="trend">
                        <p>#CostaRica</p>
                    </div>
                    <div class="trend">
                        <p>#UFidélitas</p>
                    </div>

                    <h2>Personas para seguir</h2>
                    <!-- Aquí puedes incluir contenido dinámico de personas para seguir -->
                    <div class="person-to-follow">
                        <img src="https://this-person-does-not-exist.com/img/avatar-gen11a51f475a14d52c0afabe1b9cdd0ff2.jpg"
                            alt="Avatar">
                        <p>Luis Alfonso Puertas</p>
                        <button class="follow-btn">Seguir</button>
                    </div>
                    <div class="person-to-follow">
                        <img src="https://this-person-does-not-exist.com/img/avatar-gen78c54f6dec142ac4c33c14fe035d18f6.jpg"
                            alt="Avatar">
                        <p>Vanessa Blazquez</p>
                        <button class="follow-btn">Seguir</button>
                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>


    <?php
} else {
    header("Location: ../View/index.php");
    exit();
}
?>