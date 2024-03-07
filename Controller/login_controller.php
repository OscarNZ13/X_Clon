<?php
session_start();

include('../Model/User_Model.php');

$username = $_POST['Usuario'];
$password = $_POST['Contrasena'];

$UserModel =  new UserModel();

if ($UserModel->authenticateUser($username, $password)) {
    $_SESSION['Usuario'] = $username;
    header("location: ../View/home_page.html");
} else {
    header("location: ../index.html?error=1");
}