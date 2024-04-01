<?php
session_start();

include('../Model/user_model.php');

if (!isset($_SESSION['Usuario'])) {
    header("location: index.php");
    exit();
}

$username = $_SESSION['Usuario'];
$UserModel = new UserModel();
$user = $UserModel->getUserByUsername($username);

if (!$user) {
    // Manejar la situación si no se encuentra al usuario
    header("location: error.php");
    exit();
}

$tweets = $UserModel->getTweetsByUserId($user['ID_Usuario']);

include('../View/profile.php');

