<?php
require_once "session.hidden.php";
require_once "classes.hidden.php";
require_once "database.hidden.php";

$username = $_GET["user"] ?? "";
$user = Database::get_instance()->get_user($username);
if ($user == null) {
    header("Location: .");
    exit();
}
?>

<!DOCTYPE html>
<html lang="hu">

<head>
    <?php require "meta.hidden.php"; ?>
    <title>Beállítások</title>
</head>

<body>
    <?php require "navbar.hidden.php"; ?>

    <main>
        <h1>
            <?= $user->get_name() ?>
        </h1>
        <img src="pfp/<?= $user->get_profile_picture_url() ?>" alt="profilkép" title="Avatar"
            class="image pfp center-image image-fluid round-image fade-and-scale">
        <p>Leírás:</p>
        <pre><?= $user->get_description() ?></pre>
        <p> Utoljára belépve:
            <time datetime="<?= $user->get_last_logged_in() ?>">
                <script>document.write(new Date(1000 * <?= $user->get_last_logged_in() ?>).toLocaleString())</script>
            </time>
        </p>
    </main>

    <?php include "./footer.hidden.php"; ?>
</body>

</html>