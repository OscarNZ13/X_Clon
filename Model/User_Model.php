<?php
include ('../Db/Connection_db.php');
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
        if (empty ($username) || empty ($email) || empty ($password) || empty ($location)) {
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

    public function getUserByUsername($username)
    {
        global $Conexion;$Consulta = "SELECT * FROM user WHERE Nombre = '$username'";
        $Resultado = $Conexion->query($Consulta);
        
        if ($Resultado->num_rows > 0) {
            return $Resultado->fetch_assoc();
        } else {
            return null;
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