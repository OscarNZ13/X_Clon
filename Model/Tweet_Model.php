<?php
// Tweet_Model.php

include_once('../Db/Connection_db.php');

class TweetModel
{
    // Función para crear un nuevo tweet
    public function createTweet($userID, $contenido)
    {
        global $Conexion;
        // Insertar el nuevo tweet en la base de datos
        $query = "INSERT INTO tweets (ID_Usuario, Contenido, FechaPublicacion) VALUES (?, ?, CURRENT_TIMESTAMP)";
        $stmt = $Conexion->prepare($query);
        $stmt->bind_param("is", $userID, $contenido);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    // Función para eliminar un tweet
    public function deleteTweet($tweetID, $userID)
    {
        global $Conexion;
        // Verificar si el usuario es el propietario del tweet
        $query = "SELECT ID_Usuario FROM tweets WHERE ID_Tweet = ?";
        $stmt = $Conexion->prepare($query);
        $stmt->bind_param("i", $tweetID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $tweetOwnerID = $row['ID_Usuario'];

            // Si el usuario es el propietario del tweet, eliminarlo
            if ($tweetOwnerID == $userID) {
                $query = "DELETE FROM tweets WHERE ID_Tweet = ?";
                $stmt = $Conexion->prepare($query);
                $stmt->bind_param("i", $tweetID);
                $stmt->execute();
                return $stmt->affected_rows > 0;
            } else {
                return false; // El usuario no es el propietario del tweet
            }
        } else {
            return false; // El tweet no existe
        }
    }

    // Función para obtener todos los tweets
    public function getAllTweets()
    {
        global $Conexion;
        $tweets = array();
        // Consulta SQL para recuperar los tweets
        $query = "SELECT * FROM tweets ORDER BY FechaPublicacion DESC";
        $result = $Conexion->query($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $tweets[] = $row;
            }
        }
        return $tweets;
    }
}
?>