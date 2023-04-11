<?php
spl_autoload_register(function ($class_name) {
    require "classes/" . $class_name . ".hidden.php";
});

$date = null;
$time = null;
$precision = null;
$country = null;
$type = null;

$errors = [];

/**
 * @var Sighting[]
 */
$sightings = [];

if (isset($_POST["create"])) {
    $user = SessionManager::get_session();
    $date = $_POST["date"] ?? "";
    $time = $_POST["time"] ?? "";
    $precision = $_POST["precision"] ?? "";
    $country = trim($_POST["country"] ?? "");
    $type = $_POST["type"] ?? "";

    $timestamp = strtotime($date . " " . $time);

    if ($user == null) {
        header("Location: login?error=Jelentkezz be először!");
        exit();
    }

    if (
        $date === "" ||
        $time === "" ||
        $precision === "" ||
        $country === "" ||
        $type === ""
    ) {
        $errors[] = "Minden mező kitöltése kötelező!";
    }

    if ($timestamp === false) {
        $errors[] = "Hibás dátum vagy idő!";
    }

    if ($precision < 0 || $precision > 100) {
        $errors[] = "Hibás bizonyosság!";
    } else {
        $precision = $precision / 100;
    }

    if (
        !in_array($type, [
            SightingType::Direct->name,
            SightingType::Indirect->name,
            SightingType::Other->name,
        ])
    ) {
        $errors[] = "Hibás jelentés típus!";
    }

    if (count($errors) === 0) {
        $sighting = new Sighting(
            $timestamp,
            $precision,
            $country,
            $type,
            $user->get_name()
        );
        Database::get_instance()->add_sighting($sighting);
        header("Location: finder?success=Sikeres jelentés!");
    }
}

if (SessionManager::is_logged_in()) {
    $sightings = Database::get_instance()->get_sightings_by_user(
        SessionManager::get_session()->get_name()
    );

    if (isset($_POST["delete"])) {
        $delete_timestamp = $_POST["find-timestamp"] ?? "";
        $delete_country = $_POST["find-country"] ?? "";

        foreach ($sightings as $sighting) {
            if (
                $sighting->get_timestamp() == $delete_timestamp &&
                $sighting->get_country() == $delete_country
            ) {
                Database::get_instance()->remove_sighting($sighting);
                header("Location: finder?success=Sikeres törlés!");
                exit();
            }
        }
    }    
}

$error = implode("<br>", $errors);
$_GET["errors"] = $error ?? null;

$latest_sighting = Database::get_instance()->get_latest_sighting();
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
        <h1>Pápa találat jelentése</h1>
        <div class="image center-image fade-and-scale">
            <img src="./assets/img/pope-finder.png" alt="Egy térképen fekve piros iránymutató látható."
                title="Találat jelentés" class="image-fluid image-fade-in round-image" />
        </div>
        <p>
            Segíts felderíteni a Pápa helyzetét! Ha szemtanúja voltál, esetleg ráutoló nyomot találtál Őszentsége
            tartózkodási helyére, ne habozz, töltsd ki az alábbi űrlapot!
        </p>
        <div>
            <h2> Legfrissebb jelentés: </h2>
            <?php if ($latest_sighting != null) { ?>

            <p>
                <strong>Találat ideje:</strong>
                <?= date("Y.m.d H:i", $latest_sighting->get_timestamp()) ?>
            </p>
            <p>
                <strong>Találat bizonyossága:</strong>
                <?= $latest_sighting->get_certainty() * 100 ?>%
            </p>
            <p>
                <strong>Találat országa:</strong>
                <?= $latest_sighting->get_country() ?>
            </p>
            <p>
                <strong>Találat típusa:</strong>
                <?= $latest_sighting->get_type() ?>
            </p>
            <p>
                <strong>Jelentő:</strong>
                <?php
                    $sighter = Database::get_instance()->get_user(
                        $latest_sighting->get_username()
                    );
                    if ($sighter != null && !$sighter->is_private()) {
                        echo "<a href='profile?user="  . $sighter->get_name() . "'>" . $sighter->get_name() . '</a>';
                    } else {
                        echo "Névtelen";
                    }
                ?>
            </p>
            <?php } else { ?>
            <p>
                Még nem érkezett jelentés! 🤔
            </p>
            <?php } ?>
        </div>
        <?php if (SessionManager::is_logged_in()) { ?>
        <div>
            <h2>Jelentés</h2>
            <form action="finder" method="POST">
                <fieldset>
                    <legend>Találat körülménye</legend>

                    <label>
                        Találat dátuma
                        <input type="date" name="date" required value="<?= $date ?>">
                    </label>
                    <label>
                        Találat ideje
                        <input type="time" name="time" required value="<?= $time ?>">
                    </label>

                    <label>
                        Találat bizonyossága
                        <input type="range" name="precision" min="0" max="100" value="<?= $precision ?>">
                    </label>
                    <label>
                        Találat országa
                        <input type="text" name="country" required value="<?= $country ?>">
                    </label>
                </fieldset>
                <fieldset>
                    <legend>Találat típusa</legend>

                    <select name="type">
                        <option value="<?= SightingType::Direct
                            ->name ?>" <?= $type === SightingType::Direct->name
    ? "selected"
    : "" ?>>
                            Szemtanú
                        </option>
                        <option value="<?= SightingType::Indirect
                            ->name ?>" <?= $type ===
SightingType::Indirect->name
    ? "selected"
    : "" ?>>
                            Rá utaló nyom
                        </option>
                        <option value="<?= SightingType::Other
                            ->name ?>" <?= $type === SightingType::Other->name
    ? "selected"
    : "" ?>>
                            Egyéb
                        </option>
                    </select>
                </fieldset>
                <fieldset>
                    <label><?= $error ?></label>
                    <legend>Irányítás</legend>
                    <button type="submit" name="Reset">
                        Alapállapot
                    </button>

                    <button type="submit" name="create">
                        Jelentés elküldése
                    </button>

                </fieldset>
            </form>
        </div>
        <div>
            <h2>Jelentéseim</h2>
            <?php if (count($sightings) === 0) { ?>

            <p>
                Nincs megjeleníthető jelentés!
            </p>

            <?php } else { ?>

            <table>
                <thead>
                    <tr>
                        <th>Dátum</th>
                        <th>Ország</th>
                        <th>Típus</th>
                        <th>Bizonyosság</th>
                        <th>🚮</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sightings as $sighting) { ?>
                    <tr>
                        <td><?= date(
                            "Y-m-d H:i",
                            $sighting->get_timestamp()
                        ) ?></td>
                        <td><?= $sighting->get_country() ?></td>
                        <td><?= $sighting->get_type() ?></td>
                        <td><?= $sighting->get_certainty() ?></td>
                        <td>
                            <form action="finder" method="POST">
                                <input type="hidden" name="find-timestamp" value="<?= $sighting->get_timestamp() ?>">
                                <input type="hidden" name="find-country" value="<?= $sighting->get_country() ?>">
                                <button type="submit" name="delete">
                                    🗑️
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

            <?php } ?>
        </div>
        <?php } else { ?>
        <div>
            <h2>Jelentés</h2>
            <p>
                A jelentés küldéséhez jelentkezz be!
            </p>

        </div>
        <?php } ?>
    </main>

    <?php include "templates/footer.hidden.php"; ?>
</body>

</html>