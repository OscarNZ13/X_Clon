<?php
// Incluir el controlador del perfil
include ('../Controller/profile_edit_controller.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../Public/css/sidebar.css">
    <link rel="stylesheet" href="../Public/css/styles.css">
    <link rel="stylesheet" href="../Public/css/ProfileEdit_style.css">
</head>

<body>
    <div class="container">
        <div class="grid-container">
        <div class="sidebar">
                <ul style="list-style:none;">
                    <li><i class="fa fa-twitter" style="color:#50b7f5;font-size:10px;"></i></li>

                    <li class="active_menu"><a href='../View/home_page.php'><i class="fa fa-home"
                                style="color:#50b7f5;"></i><span style="color:#50b7f5;">Home</span></a></li>

                    <li><a href='#'><i class="fa fa-hashtag"></i><span>Explorar</span></a></li>

                    <li><a href="#"><i class="fa fa-bell" aria-hidden="true"></i><span>Notificaciones</span>

                    <li id='messagePopup'><a><i class="fa fa-envelope" aria-hidden='true'></i><span>Mensajes</span>

                    <li><a href='../View/profile.php?username=<?php echo $_SESSION['Usuario']; ?>' class="Username-link"><i class="fa fa-user"></i> Perfil</a></li>

                    <li><a href='../View/profile_edit.php'><i class="fa fa-cog"></i><span>Editar Perfil</span></a></li>
                    <li>
                        <form action="../Controller/logout_controller.php" method="post">
                            <button type="submit" class="logout-btn">
                                <i class="fa fa-power-off"></i>
                                <span>Cerrar Sesión</span>
                            </button>
                        </form>
                    </li>

                    <li id='tweetButton'><button class="sidebar_tweet button addTweetBtn"
                            style="outline:none;">Tweet</button></li>
                    <li id="tweetBox" style="display:none;">
                        <form action="../Controller/tweet_controller.php" method="post" class="tweet-form">
                            <textarea name="contenido" placeholder="Escribe tu tweet aquí" required></textarea>
                            <button type="submit">Enviar</button>
                        </form>
                    </li>

                </ul>
            </div>
            <div class="main">
                <div class="profile-edit">
                    <h1>Edit Profile</h1>
                    <form action="../Controller/profile_edit_controller.php" method="POST">
                        <div class="form-group">
                            <label for="name">Nombre:</label>
                            <input type="text" id="name" name="name" value="<?php echo $user['Nombre']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email"
                                value="<?php echo $user['CorreoElectronico']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="bio">Descripción:</label>
                            <textarea id="bio" name="bio"><?php echo $user['Biografia']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="location">Ubicación:</label>
                            <input type="text" id="location" name="location" value="<?php echo $user['Ubicacion']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="profile-pic">Foto de Perfil:</label>
                            <input type="text" id="profile-pic" name="profile-pic"
                                value="<?php echo $user['FotoPerfil']; ?>">
                        </div>
                        <button type="submit" name="save_changes" value="Save Changes" class="btn-profile">Guardar cambios</button>
                    </form>
                </div>
            </div>

            <div class="right_sidebar">
                <h2>Tendencias</h2>
                <!-- Aquí puedes incluir contenido dinámico de tendencias -->
                <div class="trend">
                    <p>#ElonMusk</p>
                </div>
                <div class="trend">
                    <p>#CostaRica</p>
                </div>
                <div class="trend">
                    <p>#UFidélitas</p>
                </div>

                <h2>Personas para seguir</h2>
                <!-- Aquí puedes incluir contenido dinámico de personas para seguir -->
                <div class="person-to-follow">
                    <img src="https://this-person-does-not-exist.com/img/avatar-gen11a51f475a14d52c0afabe1b9cdd0ff2.jpg"
                        alt="Avatar">
                    <p>Luis Alfonso Puertas</p>
                    <button class="follow-btn">Seguir</button>
                </div>
                <div class="person-to-follow">
                    <img src="https://this-person-does-not-exist.com/img/avatar-gen78c54f6dec142ac4c33c14fe035d18f6.jpg"
                        alt="Avatar">
                    <p>Vanessa Blazquez</p>
                    <button class="follow-btn">Seguir</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tweetButton = document.getElementById('tweetButton');
            const tweetBox = document.getElementById('tweetBox');

            tweetButton.addEventListener('click', function () {
                if (tweetBox.style.display === 'none' || tweetBox.style.display === '') {
                    tweetBox.style.display = 'block';
                } else {
                    tweetBox.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>