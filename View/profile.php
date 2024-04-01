<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil</title>
    <link rel="stylesheet" href="../Public/css/style-complete.css">
    <link rel="stylesheet" href="../Public/css/styles.css">
</head>            
<body>
    <div class="container">
        <div class="grid-container">
            <div class="sidebar">
                <ul style="list-style:none;">
                    <li><i class="fa fa-twitter" style="color:#50b7f5;font-size:10px;"></i></li>
                    <li class="active_menu"><a href='../View/home_page.php'><i class="fa fa-home" style="color:#50b7f5;"></i><span style="color:#50b7f5;">Home</span></a></li>
                    <li><a href='#'><i class="fa fa-hashtag"></i><span>Explore</span></a></li>
                    <li><a href="#"><i class="fa fa-bell" aria-hidden="true"></i><span>Notifications</span><span id="notificaiton" class="ml-0"><span class="span-i">3</span></span></a></li>
                    <li id='messagePopup'><a><i class="fa fa-envelope" aria-hidden='true'></i><span>Messages</span><span id='messages'><span class="span-i">5</span></span></a></li>
                    <li><a href="#"><i class="fa fa-user"></i><span>Profile</span></a></li>
                    <li><a href='#'><i class="fa fa-cog"></i><span>Settings</span></a></li>
                    <li><a href='#'><i class="fa fa-power-off"></i><span>Logout</span></a></li>
                    <li style="padding:10px 40px;"><button class="sidebar_tweet button addTweetBtn" style="outline:none;">Tweet</button></li>
                </ul>
            </div>
            <div class="main">
    <div class="profile">
        <div class="profile-info">
            <img src="<?php echo $user['FotoPerfil']; ?>" alt="Foto de perfil">
            <h1><?php echo $user['Nombre']; ?></h1>
            <p>Descripción:<?php echo $user['Biografia']; ?></p>
            <p>Ubicación: <?php echo $user['Ubicacion']; ?></p>
            <form method="POST">
            <button type="submit" name="leave" class="leave-btn">Seguir</button>
            <button type="submit" name="leave" class="leave-btn">Mensaje</button>
        </form>
        </div>
        
        <div class="tweets">
    <h2>Mis Tweets</h2>
    <?php foreach ($tweets as $tweet) : ?>
        <div class="tweet">
            <p><?php echo $tweet['Contenido']; ?></p>
            <span><?php echo $tweet['FechaPublicacion']; ?></span>
            <div class="tweet-actions">
                <button class="like-btn likes-count"> <?php echo $tweet['Likes']; ?> Like</button>
                <button class="comment-btn comments-count"><?php echo $tweet['Retweets']; ?> Comentar</button>
            </div>
        </div>
    <?php endforeach; ?>
</div>
        
    </div>
</div>
            <div class="right_sidebar">
                <!-- Right sidebar content here -->
            </div>
        </div>
    </div>
</body>
</html>
