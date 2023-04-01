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
    <title>Rangsor</title>
</head>

<body>
    <?php require "navbar.hidden.php"; ?>

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
            <tr>
                <td>1</td>
                <td>Jesus</td>
                <td>100</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Popey Mc PopeFace</td>
                <td>69</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Credo in Deum Patrem omnipotentem</td>
                <td>66</td>
            </tr>
            <tr>
                <td>4</td>
                <td>The All-Seeing Father</td>
                <td>42</td>
            </tr>
            <tr>
                <td>5</td>
                <td>Béla</td>
                <td>24</td>
            </tr>
        </table>

    </main>
        
    <?php include "./footer.hidden.php"; ?>
</body>

</html>