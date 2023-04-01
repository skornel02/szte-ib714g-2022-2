<?php
if (!isset($_SESSION)) {
    session_start();
}
$error_message = null;

$username = $_POST["username"] ?? "";
$email = $_POST["email"] ?? "";
$password = $_POST["secret"] ?? "";
$password2 = $_POST["secret2"] ?? "";
$type = $_POST["action"] ?? "login";

if (key_exists("logged_in", $_SESSION) && $_SESSION["logged_in"]) {
    header("Location: .");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($type == "login") {
        if (($error_message = validate_login($username, $password)) == null) {
            // TODO login
            $_SESSION["logged_in"] = true;
            $_SESSION["username"] = $username;
            header("Location: .");
        }
    } elseif ($type == "register") {
        if (
            ($error_message = validate_register(
                $username,
                $email,
                $password,
                $password2
            )) == null
        ) {
            // TODO register
        }
    }
}

function validate_login(string $username, string $password): string|null {
    if (empty($username) || empty($password)) {
        return "Felhasználónév vagy jelszó üres!";
    }

    return null;
}

function validate_register(
    string $username,
    string $email,
    string $password,
    string $password2
): string|null {
    if (empty($username) || empty($password)) {
        return "Felhasználónév vagy jelszó üres!";
    }
    if (empty($email)) {
        return "Email cím üres!";
    }
    if ($password !== $password2) {
        return "Jelszavak nem egyeznek!";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Email nem megfelelő formátumú!";
    }

    return null;
}
?>

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
    <title>Bejelentkezés</title>
</head>

<body>
    <?php require "navbar.hidden.php"; ?>

    <main>
        <section id="login">
            <h1>Bejelentkezés</h1>
            <form method="post">
                <fieldset>
                    <legend>Bejelentkezési adatok</legend>
                    <img src="./assets/img/login-signup.png" alt="Egy ember hívogatóan kitárt karokkal áll egy ajtó előtt."
                        title="Avatar" class="image center-image image-fluid round-image fade-and-scale">
                    <label>
                        Felhasználó név
                        <input type="text" name="username" required value="<?= $username ?>">
                    </label>
                    <label for="psw">
                        Jelszó
                        <input type="password" name="secret" required value="<?= $password ?>">
                    </label>
                    <?php if ($error_message != null) {
                        echo $error_message;
                    } ?> <!-- TODO: make this pretty please -->
                    <input type="hidden" name="action" value="login">
                    <button type="submit">Bejelentkezés</button>
                </fieldset>
            </form>
            <button onclick="toggleLogin();">Regisztráció ha még nincs fiókod</button>
        </section>

        <section id="register" hidden>
            <h1>Regisztráció</h1>
            <form method="post">
                <fieldset>
                    <legend>Regisztrációs adatok</legend>
                    <img src="./assets/img/login-signup.png" alt="Egy ember hívogatóan kitárt karokkal áll egy ajtó előtt."
                        title="Avatar" class="image center-image image-fluid round-image fade-and-scale">
                    <label>
                        Felhasználó név
                        <input type="text" name="username" required value="<?= $username ?>">
                    </label>
                    <label for="psw">
                        Jelszó
                        <input type="password" name="secret" required value="<?= $password ?>">
                    </label>
                    <label for="psw">
                        Jelszó újra
                        <input type="password" name="secret2" required  value="<?= $password2 ?>">
                    </label>
                    <label>
                        E-mail
                        <input type="email" name="email" required  value="<?= $email ?>">
                    </label>
                    <?php if ($error_message != null) {
                        echo $error_message;
                    } ?> <!-- TODO: make this pretty please -->
                    <input type="hidden" name="action" value="register">
                    <button type="submit">Regisztráció</button>
                </fieldset>
            </form>
            <button onclick="toggleLogin();">Belépés ha már van fiókod</button>
        </section>
    </main>

    <script>
        var login = <?php echo $type != "register" ? "true" : "false"; ?>;

        function toggleLogin() {
            login = !login;
            if (login) {
                document.getElementById("login").style.display = "block";
                document.getElementById("register").style.display = "none";
            } else {
                document.getElementById("login").style.display = "none";
                document.getElementById("register").style.display = "block";
            }
        }

        login = !login;
        toggleLogin();
    </script>
        
    <?php include "./footer.hidden.php"; ?>
</body>

</html>