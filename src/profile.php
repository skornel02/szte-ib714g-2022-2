<?php
spl_autoload_register(function ($class_name) {
    require "classes/" . $class_name . ".hidden.php";
});

$username = $_GET["user"] ?? "";
$user = Database::get_instance()->get_user($username);

$is_self =
    SessionManager::is_logged_in() &&
    $user !== null &&
    $user->get_name() == SessionManager::get_session()->get_name();
if (
    $user == null ||
    ($user->is_private() && !SessionManager::is_admin() && !$is_self)
) {
    header("Location: .?error=Nincs ilyen felhasználó!");
    exit();
}
?>

<!DOCTYPE html>
<html lang="hu">

<head>
    <?php require "templates/meta.hidden.php"; ?>
    <title>Beállítások</title>
</head>

<body>
    <?php require "templates/navbar.hidden.php"; ?>

    <main>
        <h1>
            <?= $user->get_name() ?>
        </h1>
        <?= $user->is_admin() ? "<h2>ADMIN</h2>" : "" ?>
        <?= $user->is_private() ? "<h2>Privát profil</h2>" : "" ?>
        <?= $is_self ? "<a href=\"profile-settings\">Beállítások</a>" : "" ?>
        <img src="<?= $user->get_profile_picture_url() ?>" alt="profilkép" title="Avatar"
            class="image pfp center-image image-fluid round-image fade-and-scale">
        <p>Leírás:</p>
        <pre><?= $user->get_description() ?></pre>
        <p> Utoljára belépve:
            <time datetime="<?= $user->get_last_logged_in() ?>">
                <script>document.write(new Date(1000 * <?= $user->get_last_logged_in() ?>).toLocaleString())</script>
            </time>
        </p>
    </main>

    <?php include "templates/footer.hidden.php"; ?>
</body>

</html>