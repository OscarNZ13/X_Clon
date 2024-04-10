<?php

include('../Db/Connection_db.php');

class UserModel
{
    public function authenticateUser($username, $password)
    {
        global $Conexion;

        // Se crea la consulta para obtener el hash de la contraseña del usuario
        $Consulta = "SELECT Contraseña FROM user WHERE Nombre = '$username'";

        // Ejecutar la consulta
        $Resultado = $Conexion->query($Consulta);

        // Verificar si la consulta se ejecutó correctamente
        if (!$Resultado) {
            // Si hay un error en la consulta, se muestra un mensaje de error y se devuelve false
            echo "Error en la consulta: " . $Conexion->error;
            return false;
        }

        // Verificar si se encontraron filas en el resultado
        if ($Resultado->num_rows > 0) {
            // Obtener el hash de la contraseña del usuario
            $fila = $Resultado->fetch_assoc();
            $hashContraseña = $fila['Contraseña'];

            // Verificar si la contraseña coincide con el hash
            if (password_verify($password, $hashContraseña)) {
                // La contraseña es válida, el usuario está autenticado
                return true;
            } else {
                // La contraseña no coincide con el hash, el usuario no está autenticado
                return false;
            }
        } else {
            // Si no se encontraron filas, el usuario no está autenticado
            return false;
        }
    }

    public function RegisterUser($username, $email, $password, $location)
    {
        global $Conexion;

        // Convertir la contraseña en un hash seguro
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $Consulta = "INSERT INTO user (`Nombre`, `CorreoElectronico`, `Contraseña`, `FechaCreacion`, `Biografia`, `Ubicacion`) 
            VALUES ('$username', '$email', '$hashedPassword', current_timestamp(), 'Biografia...', '$location')";

        $Resultado = $Conexion->query($Consulta);

        // Verificar si la consulta se ejecutó correctamente
        if (!$Resultado) {
            // Si hay un error en la consulta, se muestra un mensaje de error y se devuelve false
            echo "Error en la consulta: " . $Conexion->error;
            return false;
        }

        // Verificar si se encontraron filas en el resultado
        if ($Resultado->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function ValidarDatos($username, $email, $password, $location)
    {
        // Verificar si algún campo está vacío
        if (empty($username) || empty($email) || empty($password) || empty($location)) {
            return "Todos los campos son obligatorios";
        }

        // Verificar si el correo electrónico tiene el formato correcto
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "El correo electrónico no es válido";
        }

        // Verificar si la contraseña tiene al menos 8 caracteres y contiene al menos un número y una letra
        if (strlen($password) < 8 || !preg_match("/[0-9]/", $password) || !preg_match("/[a-zA-Z]/", $password)) {
            return "La contraseña debe tener al menos 8 caracteres y contener al menos un número y una letra";
        }

        // Si todas las validaciones pasan, devuelve true
        return true;
    }

    // FUncion para traer toda la informacion de un usuario:
    public function getUserByUsername($username)
    {
        global $Conexion;
        $Consulta = "SELECT * FROM user WHERE Nombre = '$username'";
        $Resultado = $Conexion->query($Consulta);

        if ($Resultado->num_rows > 0) {
            return $Resultado->fetch_assoc();
        } else {
            return null;
        }
    }

    public function getUserById($userId)
    {
        global $Conexion;
        $Consulta = "SELECT * FROM user WHERE ID_Usuario = '$userId'";
        $Resultado = $Conexion->query($Consulta);

        if ($Resultado->num_rows > 0) {
            return $Resultado->fetch_assoc();
        } else {
            return null;
        }
    }

    // Funcion para alterar el seguimiento (Este mismo metodo elimina y añade un seguimiento):
    public function toggleFollow($ID_Seguidor, $ID_Seguido)
    {
        global $Conexion;
    
        // Verificar si ya existe una relación de seguimiento entre el seguidor y el seguido
        $ConsultaExistencia = "SELECT * FROM `relacionseguimiento` WHERE `ID_Seguidor` = '$ID_Seguidor' AND `ID_Seguido` = '$ID_Seguido'";
        $ResultadoExistencia = $Conexion->query($ConsultaExistencia);
    
        if ($ResultadoExistencia->num_rows > 0) {
            // Si ya existe la relación, eliminarla (dejar de seguir)
            $ConsultaEliminar = "DELETE FROM `relacionseguimiento` WHERE `ID_Seguidor` = '$ID_Seguidor' AND `ID_Seguido` = '$ID_Seguido'";
            $ResultadoEliminar = $Conexion->query($ConsultaEliminar);
    
            if ($ResultadoEliminar === true) {
                // Si la eliminación se realizó correctamente, se devuelve true
                return true;
            } else {
                // Si hay un error en la eliminación, se muestra un mensaje de error
                echo "Error al dejar de seguir: " . $Conexion->error;
                return false;
            }
        } else {
            // Si no existe la relación, agregarla (seguir)
            $ConsultaAgregar = "INSERT INTO `relacionseguimiento` (`ID_Seguidor`, `ID_Seguido`) VALUES ('$ID_Seguidor', '$ID_Seguido')";
            $ResultadoAgregar = $Conexion->query($ConsultaAgregar);
    
            if ($ResultadoAgregar === true) {
                // Si la inserción se realizó correctamente, se devuelve true
                return true;
            } else {
                // Si hay un error en la inserción, se muestra un mensaje de error
                echo "Error al seguir: " . $Conexion->error;
                return false;
            }
        }
    }

    public function getTweetsByUserId($userId)
    {
        global $Conexion;

        $Consulta = "SELECT * FROM tweets WHERE ID_Usuario = '$userId'";
        $Resultado = $Conexion->query($Consulta);

        $tweets = array();

        if ($Resultado->num_rows > 0) {
            while ($fila = $Resultado->fetch_assoc()) {
                $tweets[] = $fila;
            }
        }
        return $tweets;
    }
}

?>