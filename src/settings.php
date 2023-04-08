<?php
spl_autoload_register(function ($class_name) {
    require "classes/" . $class_name . ".hidden.php";
});

if (!SessionManager::is_logged_in()) {
    header("Location: login");
    exit();
}

$pfp_error = $_GET["pfp-error"] ?? null;
$description_error = $_GET["desc-error"] ?? null;
$remove_error = $_GET["remove-error"] ?? null;
$vis_error = $_GET["vis-error"] ?? null;

$_GET["error"] =
    $pfp_error ?? ($description_error ?? ($remove_error ?? $vis_error ??  (key_exists("error", $_GET) ? $_GET["error"] : null)));

/**
 * @var User
 */
$session = SessionManager::get_session() ?? die("Session error");
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
        <h1>Beállítások</h1>

        <form action="settings-process" method="post" enctype="multipart/form-data">
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
                <input type="hidden" name="action" value="<?= ProfileAction
                ::UpdateProfilePicture->name ?>">
                <button type="submit">
                    Feltöltés
                </button>
            </fieldset>
        </form>
        <form action="settings-process" method="post">
            <fieldset>
                <legend>Leírás (publikus)</legend>
                <label for="description">
                    Profil leírás
                </label>
                <textarea id="description" name="description" cols="30" rows="10"
                    maxlength="400"><?= $session->get_description() ?></textarea>
                <?php if ($description_error != null) {
                    echo $description_error;
                } ?> <!-- TODO: make this pretty please -->
                <input type="hidden" name="action" value="<?= ProfileAction
                ::UpdateDescription->name ?>">
                <button type="submit">
                    Mentés
                </button>
            </fieldset>
        </form>
        <form action="settings-process" method="post">
            <fieldset>
                <legend>Fiók láthatóság</legend>
                <label>
                    Látható mindenki által
                    <input type="checkbox" name="visible" <?= $session->is_private() ? "" : "checked" ?>>
                </label>
                <input type="hidden" name="action" value="<?= ProfileAction
                ::UpdateVisibility->name ?>">
                <button type="submit">
                    Mentés
                </button>
            </fieldset>
        </form>
        <form action="settings-process" method="post">
            <fieldset>
                <legend>Fiók törlés</legend>
                <label>
                    Jelszó
                    <input type="password" name="password" minlength="8">
                </label>
                <?php if ($remove_error != null) {
                    echo $remove_error;
                } ?> <!-- TODO: make this pretty please -->
                <input type="hidden" name="action" value="<?= ProfileAction
                ::DeleteProfile->name ?>">
                <button type="submit">
                    Mentés
                </button>
            </fieldset>
        </form>
    </main>

    <?php include "templates/footer.hidden.php"; ?>
</body>

</html>