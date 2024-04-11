<?php
// users_page_controller.php

session_start();
include_once('../Db/Connection_db.php');
include_once('../Model/User_Model.php');

$User_f = $_POST['user_id_f'];
$User_l = $_POST['user_id_l'];

// Verificar si se ha iniciado sesión
if (isset($_SESSION['Usuario'])) {

    $User = $_SESSION['Usuario'];

    $UserModel = new UserModel();

    if ($UserModel->toggleFollow($User_l, $User_f)) {
        header("location: ../View/users_page.php");
    }else{
        printf("Error al seguir usuario");
    }

} else {
    // Redirigir al usuario a la página de inicio de sesión si no ha iniciado sesión
    header("Location: ../View/index.php");
    exit();
}
