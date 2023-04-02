<?php
require_once "session.hidden.php";
require_once "classes.hidden.php";

if (!SessionManager::is_logged_in()) {
    header("Location: login");
    exit();
}

$pfp_error = $_GET["pfp-error"] ?? null;
$description_error = $_GET["desc-error"] ?? null;

/**
 * @var User
 */
$session = SessionManager::get_session() ?? die("Session error");
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
        <h1>Beállítások</h1>
        <h2>
            Üdvözlünk
            <?= $session->get_name() ?>!
        </h2>
        <p> Utoljára belépve: 
            <time datetime="<?= $session->get_last_logged_in() ?>">
                <script>document.write(new Date(1000 * <?= $session->get_last_logged_in() ?>).toLocaleString())</script>
            </time>
        </p>

        <form action="update-pfp" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>Profilkép (publikus)</legend>
                <img src="pfp/<?= SessionManager::get_session()->get_profile_picture_url() ?>" alt="profilkép"
                    title="Avatar" class="image pfp center-image image-fluid round-image fade-and-scale">
                <label>
                    Profilkép megváltoztatása
                    <input type="file" id="img" name="profile-picture" accept="image/*">
                </label>
                <?php if ($pfp_error != null) {
                    echo $pfp_error;
                } ?> <!-- TODO: make this pretty please -->
                <button type="submit">
                    Feltöltés
                </button>
            </fieldset>
        </form>
        <form action="update-description" method="post">
            <fieldset>
                <legend>Leírás (publikus)</legend>
                <label for="description">
                    Profil leírás
                </label>
                <textarea id="description" name="description" cols="30" rows="10" maxlength="400"><?= $session->get_description() ?></textarea>
                <?php if ($description_error != null) {
                    echo $description_error;
                } ?> <!-- TODO: make this pretty please -->
                <button type="submit">
                    Mentés
                </button>
            </fieldset>
        </form>
    </main>

    <?php include "./footer.hidden.php"; ?>
</body>

</html>