<?php
spl_autoload_register(function ($class_name) {
    require "classes/" . $class_name . ".hidden.php";
});


if (!SessionManager::is_admin()) {
    header("Location: .?error=Csak adminoknak elérhető!");
    exit();
}

$users = Database::get_instance()->get_users();
$sightings = Database::get_instance()->get_sightings();

if (isset($_POST["find-delete"])) {
    $username = $_POST["find-username"] ?? "";
    $timestamp = $_POST["find-timestamp"] ?? "";
    $country = $_POST["find-country"] ?? "";

    foreach ($sightings as $sighting) {
        if (
            $sighting->get_username() == $username &&
            $sighting->get_timestamp() == $timestamp &&
            $sighting->get_country() == $country
        ) {
            Database::get_instance()->remove_sighting($sighting);
            header("Location: admin?success=Sikeres törlés!");
            exit();
        }
    }
}

if (isset($_POST["user-delete"])) {
    $username = $_POST["user-username"] ?? "";

    foreach ($users as $user) {
        if ($user->get_name() == $username) {
            Database::get_instance()->remove_user($user);
            header("Location: admin?success=Sikeres törlés!");
            exit();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="hu">

<head>
    <?php require "templates/meta.hidden.php"; ?>
    <title>Kereső</title>
</head>

<body>
    <?php require "templates/navbar.hidden.php"; ?>

    <main>
        <h1 class="full-width-title">Admin funkciók</h1>
        <hr>
        <h2>Felhasználók
            <?= "(" . count($users) . ")" ?>
        </h2>
        <table>
            <thead>
                <tr>
                    <th>Felhasználónév</th>
                    <th>Emailcím</th>
                    <th>🚮</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td>
                            <a href="profile?user=<?= $user->get_name() ?>">
                                <?= $user->get_name() ?>
                            </a>
                        </td>
                        <td>
                            <?= $user->get_email() ?>
                        </td>
                        <td>
                            <form action="admin" method="POST">
                                <input type="hidden" name="user-username" value="<?= $user->get_name() ?>">
                                <button type="submit" name="user-delete">
                                    🗑️
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <hr>
        <h2>Észlelések
            <?= "(" . count($sightings) . ")" ?>
        </h2>
        <table>
            <thead>
                <tr>
                    <th>Felhasználó</th>
                    <th>Észlelés</th>
                    <th>Észlelés ideje</th>
                    <th>🚮</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sightings as $sighting): ?>
                    <tr>
                        <td>
                            <a href="profile?user=<?= $sighting->get_username() ?>">
                                <?= $sighting->get_username() ?>
                            </a>
                        </td>
                        <td>
                            <?= $sighting->get_country() ?> |
                            <?= $sighting->get_type() ?> (
                            <?= $sighting->get_certainty() ?>)
                        </td>
                        <td>
                            <?= date("Y-m-d H:i", $sighting->get_timestamp()) ?>
                        </td>
                        <td>
                            <form action="admin" method="POST">
                                <input type="hidden" name="find-username" value="<?= $sighting->get_username() ?>">
                                <input type="hidden" name="find-timestamp" value="<?= $sighting->get_timestamp() ?>">
                                <input type="hidden" name="find-country" value="<?= $sighting->get_country() ?>">
                                <button type="submit" name="find-delete">
                                    🗑️
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

    <?php include "templates/footer.hidden.php"; ?>
</body>

</html>