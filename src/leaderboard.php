<?php
spl_autoload_register(function ($class_name) {
    require "classes/" . $class_name . ".hidden.php";
});

$users = Database::get_instance()->get_users();
?>

<!DOCTYPE html>
<html lang="hu">

<head>
    <?php require "templates/meta.hidden.php"; ?>
    <title>Rangsor</title>
    <style>
        <?php for ($i = 1; $i <= count($users); $i++) {
            echo "tr:nth-child(" .
                $i +
                1 .
                ") { animation-delay: " .
                ($i - 1) .
                "s; }\n";
        } ?>
    </style>
</head>

<body>
    <?php require "templates/navbar.hidden.php"; ?>

    <main>
        <h1>Ranglétra</h1>
        <p>
            Itt láthatóak a legtöbb észlelést beküldő felhasználók. Küldj be te is jelentést, hogy itt láthasd a neved!
        </p>
        <div class="image center-image fade-and-scale">
            <img src="./assets/img/leader-board.png" alt="Három ember körüláll egy pódiumot." title="Ranglétra"
                class="image-fluid image-fade-in round-image" />
        </div>

        <table>
            <tr>
                <th>Helyezés</th>
                <th>Bejelentő neve</th>
                <th>Bejelentések száma</th>
            </tr>
            <?php foreach ($users as $index => $user): ?>

                <tr id="tr<?= $index ?>">
                    <td>
                        <?= $index + 1 ?>
                    </td>
                    <td>
                        <a href="<?= $user->is_private() &&
                        !SessionManager::is_admin()
                            ? "#tr$index"
                            : "profile?user=" . $user->get_name() ?>">
                            <?= $user->is_private() &&
                            !SessionManager::is_admin()
                                ? "[PRIVATE]"
                                : $user->get_name() ?>
                        </a>
                    </td>
                    <td>
                        <?= rand(3, 42690) ?>
                    </td>
                </tr>


            <?php endforeach; ?>
        </table>

    </main>

    <?php include "templates/footer.hidden.php"; ?>
</body>

</html>