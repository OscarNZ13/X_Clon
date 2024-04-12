<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('../Model/user_model.php');

if (!isset($_SESSION['Usuario'])) {
    header("location: index.php");
    exit();
}

$username = $_SESSION['Usuario'];
$UserModel = new UserModel();
$user = $UserModel->getUserByUsername($username);

if (!$user) {
    // Handle the situation if the user is not found
    header("location: error.php");
    exit();
}

$tweets = $UserModel->getTweetsByUserId($user['ID_Usuario']);

