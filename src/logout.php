<?php
require_once "session.hidden.php";

SessionManager::end_session();
?>

<!DOCTYPE html>
<html lang="hu">
    <head>
        <?php require "meta.hidden.php"; ?>
        <link rel="icon" href="./assets/img/favicon.ico" type="image/x-icon">
        <title>Főoldal</title>
    </head>

    <body>
        <?php require "navbar.hidden.php"; ?>

        <div id="hero">
            <div class="video-container">
                <video autoplay muted loop> 
                    <source src="./assets/media/giga-pope.mp4" type="video/mp4">
                </video>
                <div class="text-highlight">
                    <h1>Kijelentkezés...</h1>
                </div>
            </div>
        </div>

        <script>
            setTimeout(() => {
                window.location.href = "./?success=Kijelentkezés sikeres!";
            }, 3000);
        </script>

        <?php include "./footer.hidden.php"; ?>
    </body>
</html>
