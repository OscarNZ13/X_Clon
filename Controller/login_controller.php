<?php
session_start();

include('../Model/User_Model.php');

$username = $_POST['Usuario'];
$password = $_POST['Contrasena'];

$UserModel = new UserModel();

if ($UserModel->authenticateUser($username, $password)) {
    $_SESSION['Usuario'] = $username;
    header("location: ../View/home_page.php");
} else {
    $_SESSION['error'] = "Usuario o contraseña incorrectos";
    header("location: ../View/index.php");
}