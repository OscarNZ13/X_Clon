<?php
include('../Db/Connection_db.php');

class UserModel
{
    public function authenticateUser($username, $password)
    {
        global $Conexion;

        // Se crea la consulta para autenticar al usuario
        $Consulta = "SELECT * FROM user WHERE Nombre = '$username' AND Contraseña = '$password'";

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
            // Si se encontraron filas, el usuario está autenticado y se devuelve true
            return true;
        } else {
            // Si no se encontraron filas, el usuario no está autenticado y se devuelve false
            return false;
        }
    }

    public function RegisterUser($username, $password){
        global $Conexion;
        
    }
}