<?php
class UserModel
{
    public function authenticateUser($username, $password)
    {
        include('../Db/Connection_db.php');

        // Verificar si la conexión a la base de datos se estableció correctamente
        if ($Conexion->connect_errno) {
            // Si hay un error de conexión, se muestra un mensaje de error y se devuelve false
            echo "Error de conexión a la base de datos: " . $Conexion->connect_error;
            return false;
        }

        // Se crea la consulta para autenticar al usuario
        $Consulta = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";

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

        // Cerrar la conexión a la base de datos
        $Conexion->close();
    }
}