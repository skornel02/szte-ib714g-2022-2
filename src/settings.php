<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="author" content="Horváth Gergely Zsolt" />
    <meta name="author" content="Stefán Kornél" />
    <meta name="generator" content="Embergép" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="styles/global.css" />
    <link rel="icon" href="./assets/img/favicon.ico" type="image/x-icon">
    <title>Beállítások</title>
</head>

<body>
    <?php require "navbar.hidden.php"; ?>

    <main>
        <h1>Beállítások</h1>

        <form action="/action_page.php">
            <fieldset>
                <legend>Profil módosítása</legend>
                <label>
                    Új email cím megadása
                    <input type="email" name="email">
                </label>
                <label>
                    Új jelszó megadása
                    <input type="password" name="secret">
                </label>
                <label>
                    Új telefonszám megadása
                    <input type="tel" name="phone">
                </label>
                <label>
                    Profilkép megváltoztatása
                    <input type="file" id="img" name="img" accept="image/*">
                </label>

                <button type="submit">
                    Beállítások mentése
                </button>
            </fieldset>

        </form>
    </main>
        
    <?php include "./footer.hidden.php"; ?>
</body>

</html>