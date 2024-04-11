<?php
//register_controller.php

session_start();

include ('../Model/User_Model.php');

// Obtener datos del formulario
$username = $_POST['Usuario'];
$password = $_POST['Contrasena'];
$email = $_POST['Email'];
$location = $_POST['Locacion'];

$UserModel = new UserModel();

// Validar y registrar al usuario
$validacion = $UserModel->ValidarDatos($username, $email, $password, $location);
if ($validacion === true) {
    // Los datos son válidos, intenta registrar al usuario
    $registro = $UserModel->RegisterUser($username, $email, $password, $location);
    if ($registro === true) {
        $_SESSION['Usuario'] = $username;
        header("location: ../View/index.php");
    } else {
        // Si hubo un error al registrar al usuario, redirige a la página de registro con el mensaje de error
        header("location: ../View/register.php?error=" . urlencode($registro));
    }
} else {
    // Los datos no son válidos, redireccionar al formulario de registro con el mensaje de error
    $error_message = "Error: " . $validacion;
    header("location: ../View/register.php?error=" . urlencode($error_message));
}
?>