<?php
define("MAXUSER", 3);

spl_autoload_register(function ($class_name) {
    require "classes/" . $class_name . ".hidden.php";
});

if (isset($_GET["allusers"])) {
    setcookie("allusers", $_GET["allusers"] === "true" ? "true" : "", time() + 60 * 60 * 24 * 30);
    header("Location: leaderboard");
}

$users = Database::get_instance()->get_users();

$topList = [];

foreach ($users as $user) {
    $topList[$user->get_name()] = count(
        Database::get_instance()->get_sightings_by_user($user->get_name())
    );
}

arsort($topList);

$all_users_show = $_COOKIE["allusers"] ?? false;

if (!$all_users_show) {
    $topList = array_slice($topList, 0, min(MAXUSER, count($users)), true);
}

$index = 1;
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
            <?php foreach ($topList as $username => $amount): ?>
                <?php $user = Database::get_instance()->get_user($username); ?>
                <tr id="tr<?= $index ?>">
                    <td>
                        <?= $index ?>
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
                        <?= $amount ?>
                    </td>
                </tr>


                <?php $index++; endforeach; ?>
        </table>
        <hr>
        <?php if (!$all_users_show): ?>
            <div class="center">
                <a href="leaderboard?allusers=true">Mutasd az összes felhasználót</a>
            </div>
        <?php else: ?>
            <div class="center">
                <a href="leaderboard?allusers=false">Csak a legjobbakat mutasd</a>
            </div>
        <?php endif; ?>
    </main>

    <?php include "templates/footer.hidden.php"; ?>
</body>

</html>