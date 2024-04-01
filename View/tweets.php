<?php

include_once('../Db/Connection_db.php');
include_once('../Model/Tweet.php');

// Crear un nuevo tweet
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["contenido"])) {
    // Obtener el contenido del tweet desde el formulario
    $contenido = $_POST["contenido"];

    // Definir el ID de usuario
    $userID = 1;

    // Crear una instancia de Tweet con los datos
    $tweet = new Tweet($userID, $contenido);

    // Insertar el nuevo tweet en la base de datos
    $query = "INSERT INTO tweets (ID_Usuario, Contenido, FechaPublicacion) VALUES (?, ?, CURRENT_TIMESTAMP)";
    $stmt = $Conexion->prepare($query);
    $stmt->bind_param("is", $tweet->ID_Usuario, $tweet->Contenido);
    $stmt->execute();
}

//Eliminar un tweet
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["eliminar_tweet"])) {
    // Obtener el ID del tweet a eliminar
    $tweetID = $_POST["tweet_id"];

    // Realizar la eliminación del tweet en la base de datos
    $query = "DELETE FROM tweets WHERE ID_Tweet = ?";
    $stmt = $Conexion->prepare($query);
    $stmt->bind_param("i", $tweetID);
    $stmt->execute();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tweets</title>
    <link rel="stylesheet" href="../Public/css/style.css">
    <link rel="stylesheet" href="../Public/css/style_tweet.css">
</head>

<body>
    <div class="layout">
        <div class="aside">
            <div class="Logo-box">
                <a href="http://">
                    <img class="Logo-X" src="../Public/img/X_logo.png" alt="Logo X">
                </a>
            </div>

            <div class="Perfil-box">
                <div class="Perfil-img">
                    <img class="User-pic" src="https://cdn.vectorstock.com/i/preview-1x/77/30/default-avatar-profile-icon-grey-photo-placeholder-vector-17317730.jpg" alt="" srcset="">
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

            <!-- Formulario para la creación de nuevos tweets -->
            <div class="tweet-form">
                <form action="tweets.php" method="post">
                    <textarea name="contenido" placeholder="Escribe tu tweet aquí" required></textarea>
                    <button type="submit">Enviar</button>
                </form>
            </div>
        </div>

        <div class="main">
            <div class="tweet-container">
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

                        // Formulario para eliminar el tweet
                        echo '<form action="tweets.php" method="post">';
                        echo '<input type="hidden" name="tweet_id" value="' . $tweetID . '">';
                        echo '<button type="submit" name="eliminar_tweet">Eliminar</button>';
                        echo '</form>';

                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo "No hay tweets disponibles.";
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>