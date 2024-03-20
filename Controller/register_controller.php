<?php
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
    if ($UserModel->RegisterUser($username, $email, $password, $location)) {
        $_SESSION['Usuario'] = $username;
        header("location: ../View/home_page.php");
    } else {
        header("location: ../View/register.php?error=1");
    }
} else {
    // Los datos no son válidos, redireccionar al formulario de registro con el mensaje de error
    header("location: ../View/register.php?error=" . urlencode($validacion));
}