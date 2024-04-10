<?php
session_start();
include_once('../Db/Connection_db.php');
include_once('../Model/User_Model.php');
include_once('../Model/Tweet_Model.php');

// Verificar si se ha iniciado sesión
if (isset($_SESSION['Usuario'])) {
    $username = $_SESSION['Usuario'];

    // Obtener el ID de usuario del usuario logueado
    $userModel = new UserModel();
    $user = $userModel->getUserByUsername($username);
    if ($user) {
        $userID = $user['ID_Usuario'];

        // Verificar si se ha enviado el formulario de creación o eliminación de tweet
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Verificar si se ha enviado el contenido del tweet
            if (isset($_POST['contenido'])) {
                $contenido = $_POST['contenido'];

                // Crear una nueva instancia de TweetModel y llamar a la función createTweet
                $tweetModel = new TweetModel();
                if ($tweetModel->createTweet($userID, $contenido)) {
                    // Redirigir a la página de inicio
                    header("Location: ../View/home_page.php");
                    exit();
                } else {
                    // Manejar el error en caso de que la creación del tweet falle
                    echo "Error al crear el tweet.";
                }
            } elseif (isset($_POST['delete_tweet'])) {
                // Verificar si se ha enviado la solicitud de eliminar un tweet
                $tweetID = $_POST['tweet_id'];

                // Crear una nueva instancia de TweetModel y llamar a la función deleteTweet
                $tweetModel = new TweetModel();
                if ($tweetModel->deleteTweet($tweetID, $userID)) {
                    // Redirigir a la página de inicio
                    header("Location: ../View/home_page.php");
                    exit();
                } else {
                    // Manejar el error en caso de que la eliminación del tweet falle
                    echo "Error al eliminar el tweet. Solo puedes eliminar tus propios tweets.";
                }
            }
        }
    } else {
        // Manejar el error en caso de que no se pueda obtener el ID de usuario
        echo "Error: No se pudo obtener el ID de usuario.";
    }
} else {
    // Redirigir al usuario a la página de inicio de sesión si no ha iniciado sesión
    header("Location: ../View/index.php");
    exit();
}
?>