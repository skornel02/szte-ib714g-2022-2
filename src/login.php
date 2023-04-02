<?php
require_once "session.hidden.php";
require_once "classes.hidden.php";
require_once "database.hidden.php";

$error_message = null;

$username = $_POST["username"] ?? "";
$email = $_POST["email"] ?? "";
$password = $_POST["secret"] ?? "";
$password2 = $_POST["secret2"] ?? "";
$type = $_POST["action"] ?? "login";

if (SessionManager::is_logged_in()) {
    header("Location: .");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($type == "login") {
        if (($error_message = validate_login($username, $password)) == null) {
            $error_message = handle_login($username, $password);
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
            $error_message = handle_register($username, $email, $password);
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
    if (strlen($password) < 8) {
        return "Jelszó legalább 8 karakter kell, hogy legyen!";
    }

    return null;
}

function handle_login(string $username, string $password): string|null {
    global $error_message;

    /**
     * @var User|null
     */
    $user = null;

    foreach (Database::get_instance()->get_users() as $match) {
        if ($match->get_name() == $username) {
            $user = $match;
            break;
        }
    }

    if ($user == null) {
        return "Nincs ilyen felhasználó!";
    }

    if (!$user->verify_password($password)) {
        return "Hibás jelszó!";
    }

    SessionManager::login($user);
    $user->set_last_logged_in(time());
    Database::get_instance()->update_user($user);
    header(
        "Location: profile?user=" .
            $user->get_name() .
            "&success=Bejelentkezés sikeres!"
    );
    return null;
}

function handle_register(
    string $username,
    string $email,
    string $password
): string|null {
    global $error_message;

    foreach (Database::get_instance()->get_users() as $match) {
        if ($match->get_name() == $username) {
            return "Már létezik ilyen felhasználó!";
        }
        if ($match->get_email() == $email) {
            return "Már létezik ilyen email cím!";
        }
        if ($match->verify_password($password)) {
            return "Már létezik ilyen jelszó! (Felhasználónév: '" .
                $match->get_name() .
                "', légyszi beszélj vele, ha szeretnéd ezt a jelszót.)";
        }
    }

    $user = User::create_new($username, $email, $password);
    Database::get_instance()->add_user($user);
    header("Location: login?success=Regisztráció sikeres!");
    return null;
}
?>

<!DOCTYPE html>
<html lang="hu">

<head>
    <?php require "meta.hidden.php"; ?>
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
                    <img src="./assets/img/login-signup.png"
                        alt="Egy ember hívogatóan kitárt karokkal áll egy ajtó előtt." title="Avatar"
                        class="image center-image image-fluid round-image fade-and-scale">
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
                    <img src="./assets/img/login-signup.png"
                        alt="Egy ember hívogatóan kitárt karokkal áll egy ajtó előtt." title="Avatar"
                        class="image center-image image-fluid round-image fade-and-scale">
                    <label>
                        Felhasználó név
                        <input type="text" name="username" required value="<?= $username ?>">
                    </label>
                    <label for="psw">
                        Jelszó
                        <input type="password" name="secret" minlength="8" required value="<?= $password ?>">
                    </label>
                    <label for="psw">
                        Jelszó újra
                        <input type="password" name="secret2" minlength="8" required value="<?= $password2 ?>">
                    </label>
                    <label>
                        E-mail
                        <input type="email" name="email" required value="<?= $email ?>">
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