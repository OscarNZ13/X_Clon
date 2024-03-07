<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "db_x";

// Crear conexión
$Conexion = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($Conexion->connect_error) {
    die("Conexión fallida: " . $Conexion->connect_error);
}