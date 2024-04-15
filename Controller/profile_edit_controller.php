<?php
session_start(); // Iniciar sesión si no está iniciada

require_once "../Model/User_Model.php"; // Incluir el modelo de usuario

$userModel = new UserModel(); // Crear una instancia del modelo de usuario

// Obtener el nombre de usuario de la sesión
$username = isset($_SESSION['Usuario']) ? $_SESSION['Usuario'] : null;

if (!$username) {
    header("location: ../View/index.php");
    exit();
}

// Obtener los datos del usuario por su nombre de usuario
$user = $userModel->getUserByUsername($username);

// Verificar si se encontraron los datos del usuario
if (!$user) {
    // Manejar el caso en que no se encuentren los datos del usuario
    echo "Error: No se encontraron datos del usuario.";
    exit();
}

// Procesar el formulario si se envió
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {
    require_once "../Db/Connection_db.php"; // Include database connection script

    // Get form data and sanitize inputs
    $name = mysqli_real_escape_string($Conexion, $_POST["name"]);
    $email = mysqli_real_escape_string($Conexion, $_POST["email"]);
    $bio = mysqli_real_escape_string($Conexion, $_POST["bio"]);
    $location = mysqli_real_escape_string($Conexion, $_POST["location"]);
    $profilePic = mysqli_real_escape_string($Conexion, $_POST["profile-pic"]);
    $nameChanged = $_POST['name_changed']; // Obtener el valor del campo oculto
    // Check if the name has changed
    $nameHasChanged = $name !== $user['Nombre'];

    // Update user profile in database with the profile picture URL
    $sql = "UPDATE user SET Nombre='$name', CorreoElectronico='$email', Biografia='$bio', Ubicacion='$location', FotoPerfil='$profilePic' WHERE Nombre='$username'";

    if ($Conexion->query($sql) === TRUE) {
        // Profile updated successfully
        $_SESSION['success_message'] = "Perfil se actualizó correctamente!";
        if ($nameHasChanged && $nameChanged === "true") {
            // Si el nombre ha sido cambiado, desloguear al usuario
            unset($_SESSION['Usuario']);
            session_destroy();
            header("location: ../View/index.php"); // Redirigir al inicio de sesión
            exit();
        } else {
            header("location: ../View/profile.php?username=" . $username); // Redirect back to profile edit page
            exit();
        }
    } else {
        $_SESSION['error_message'] = "Error actualizando el perfil: " . $Conexion->error;
    }

    $Conexion->close(); // Close database connection
}