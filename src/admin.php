<?php
spl_autoload_register(function ($class_name) {
    require "classes/" . $class_name . ".hidden.php";
});

$users = Database::get_instance()->get_users();
$sightings = Database::get_instance()->get_sightings();
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
        <h1>Admin funkciók</h1>
        <hr>
        <h2>Felhasználók <?= "(" . count($users) . ")" ?>
        </h2>
        <table>
            <thead>
                <tr>
                    <th>Felhasználónév</th>
                    <th>Emailcím</th>
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
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <hr>
        <h2>Észlelések <?= "(" . count($sightings) . ")" ?>
        </h2>
        <table>
            <thead>
                <tr>
                    <th>Felhasználó</th>
                    <th>Észlelés</th>
                    <th>Észlelés ideje</th>
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
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

    <?php include "templates/footer.hidden.php"; ?>
</body>

</html>