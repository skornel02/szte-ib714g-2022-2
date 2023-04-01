<?php
if (!isset($_SESSION)) {
    session_start();
}
session_destroy();
?>

<!DOCTYPE html>
<html lang="hu">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="author" content="Horváth Gergely Zsolt" />
        <meta name="author" content="Stefán Kornél" />
        <meta name="generator" content="Embergép" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="styles/global.css" />
        <link rel="stylesheet" href="styles/index.css" />
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
                window.location.href = "./";
            }, 3000);
        </script>

        <?php include "./footer.hidden.php"; ?>
    </body>
</html>
