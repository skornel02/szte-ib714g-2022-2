<!DOCTYPE html>
<html lang="hu">

<head>
    <?php require "meta.hidden.php"; ?>
    <title>Kereső</title>
</head>

<body>
    <?php require "navbar.hidden.php"; ?>

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
        <h2>Jelentés</h2>
        <form action="POST">
            <fieldset>
                <legend>Személyes adatok</legend>
                <label>
                    Keresztnév
                    <input type="text" name="firstname" required>
                </label>
                <label>
                    Vezetéknév
                    <input type="text" name="lastname">
                </label>
                <label>
                    Jelkód
                    <input type="password" name="secret" required>
                </label>
                <label>
                    Telefonszám
                    <input type="tel" name="phone">
                </label>
                <label>
                    E-mail
                    <input type="email" name="email" required>
                </label>
            </fieldset>
            <fieldset>
                <legend>Találat körülménye</legend>

                <label>
                    Találat dátuma
                    <input type="date" name="date" required>
                </label>
                <label>
                    Találat ideje
                    <input type="time" name="time" required>
                </label>

                <label>
                    Találat bizonyossága
                    <input type="range" name="precision">
                </label>
                <label>
                    Találat országa
                    <input type="text" name="country" required>
                </label>
            </fieldset>
            <fieldset>
                <legend>Találat típusa</legend>

                <select name="type">
                    <option value="direct">
                        Szemtanú
                    </option>
                    <option value="indirect">
                        Rá utaló nyom
                    </option>
                    <option value="other">
                        Egyéb
                    </option>
                </select>
            </fieldset>
            <fieldset>
                <legend>Irányítás</legend>
                <button type="reset">
                    Alapállapot
                </button>

                <button type="submit">
                    Jelentés elküldése
                </button>

            </fieldset>
        </form>
    </main>
        
    <?php include "./footer.hidden.php"; ?>
</body>

</html>