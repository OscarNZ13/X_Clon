<?php

include ('../Db/Connection_db.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="../Public/css/style.css" rel="stylesheet">
    <link href="../Public/css/style_tweet.css" rel="stylesheet">
</head>

<body>
    <section class="layout">

        <div class="aside">
            <div class="Logo-box">
                <a href="http://">
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
                    User
                </p>

                <button class="Btn-editar-perfil" type="button">
                    Editar
                </button>
            </div>

            <div class="Btn-Message-box">
                <button type="button" class="Btn-Message">
                    Mensajes
                </button>
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


            <div class="Nuevo-post-box">
                <button type="button" class="Btn-new-post">
                    Nuevo Post
                </button>
            </div>
        </div>

        <div class="main">
            <?php
            // Consulta SQL para recuperar los tweets
            $query = "SELECT * FROM tweets ORDER BY FechaPublicacion DESC";
            $result = $Conexion->query($query);

            if ($result->num_rows > 0) {
                // Iterar sobre los resultados y mostrar los tweets
                while ($row = $result->fetch_assoc()) {
                    $tweetID = $row['ID_Tweet'];
                    $userID = $row['ID_Usuario'];
                    $tweetContent = $row['Contenido'];
                    $tweetDate = $row['FechaPublicacion'];
                    $likes = $row['Likes'];
                    $retweets = $row['Retweets'];

                    // Consultar el nombre de usuario en la tabla de usuarios
                    $user_query = "SELECT Nombre FROM user WHERE ID_Usuario = $userID";
                    $user_result = $Conexion->query($user_query);
                    if ($user_result->num_rows > 0) {
                        $user_row = $user_result->fetch_assoc();
                        $username = $user_row['Nombre'];
                    } else {
                        $username = "Usuario Desconocido"; // Si no se encuentra el usuario, mostrar un nombre genérico
                    }

                    // Mostrar el tweet con toda la información
                    echo '<div class="tweet">';
                    echo '<div class="user-info">';
                    echo '<img src="ruta/a/tu/imagen_de_perfil.jpg" alt="Avatar" class="user-avatar">'; // Reemplaza "ruta/a/tu/imagen_de_perfil.jpg" con la ruta de la imagen de perfil del usuario
                    echo '<p class="username">' . $username . '</p>';
                    echo '</div>';
                    echo '<p class="tweet-content">' . $tweetContent . '</p>';
                    echo '<div class="tweet-footer">';
                    echo '<span class="tweet-date">' . $tweetDate . '</span>';
                    echo '<p class="tweet-info">Likes: ' . $likes . ' | Retweets: ' . $retweets . '</p>';
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