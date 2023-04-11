<?php
spl_autoload_register(function ($class_name) {
    require "classes/" . $class_name . ".hidden.php";
});

$username = $_GET["user"] ?? "";
$user = Database::get_instance()->get_user($username);

$is_self =
    SessionManager::is_logged_in() &&
    $user !== null &&
    $user->get_name() == SessionManager::get_session()->get_name();

$can_see = $user !== null && !$user->is_private() || $is_self || SessionManager::is_admin();

if ($user == null || !$can_see) {
    header("Location: .?error=Nincs ilyen felhasználó!");
    exit();
}

$session = SessionManager::get_session();

$comment_error = null;
if (isset($_POST["add-comment"])) {
    $message = trim($_POST["message"] ?? "");
    $errors = [];

    if ($session === null) {
        $errors[] = "Be kell jelentkezni, hogy kommentelhess!";
        header("Location: login?error=" . urlencode($errors[0]));
        exit();
    }

    if (empty($message)) {
        $errors[] = "Üres kommentet nem lehet létrehozni!";
    }

    if (strlen($message) > 255) {
        $errors[] = "A komment túl hosszú! Max 255 karakter lehet!";
    }

    if (count($errors) === 0) {
        $msg = Message::create_new($message, $session->get_name(), $user->get_name());
        Database::get_instance()->add_message($msg);
        header("Location: profile?user=" . $user->get_name());
        exit();
    }
}

$comments = Database::get_instance()->get_messages_by_user($user->get_name());
$sightings_amount = count(Database::get_instance()->get_sightings_by_user($user->get_name()));

if (isset($_POST["delete-comment"]) && $session !== null) {
    $comment_content = $_POST["comment-message"] ?? "";
    $comment_date = $_POST["comment-date"] ?? "";
    
    foreach ($comments as $comment) {
        if ($comment->get_message() == $comment_content 
            && $comment->get_date() == $comment_date
            && ($session->get_name() == $comment->get_sender_name() || $session->is_admin() || $is_self)) {
            Database::get_instance()->remove_message($comment);
            header("Location: profile?user=" . $user->get_name());
            exit();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="hu">

<head>
    <?php require "templates/meta.hidden.php"; ?>
    <title>Beállítások</title>
</head>

<body>
    <?php require "templates/navbar.hidden.php"; ?>

    <main>
        <h1>
            <?= $user->get_name() ?>
        </h1>
        <?= $user->is_admin() ? "<h2>ADMIN</h2>" : "" ?>
        <?= $user->is_private() ? "<h2>Privát profil</h2>" : "" ?>
        <?= $is_self ? "<a href=\"profile-settings\">Beállítások</a>" : "" ?>
        <img src="<?= $user->get_profile_picture_url() ?>" alt="profilkép" title="Avatar"
            class="image pfp center-image image-fluid round-image fade-and-scale">
        <p> Utoljára belépve:
            <time datetime="<?= $user->get_last_logged_in() ?>">
                <script>document.write(new Date(1000 * <?= $user->get_last_logged_in() ?>).toLocaleString())</script>
            </time>
        </p>
        <p> Jelentések: <?= $sightings_amount ?></p>
        <hr>
        <p>Leírás:</p>
        <pre><?= $user->get_description() ?></pre>
        <hr>
        <h2>Kommentek</h2>

        <?php if (count($comments) == 0) { ?>
        <p>Nincs megjeleníthető komment.</p>
        <hr>
        <?php } ?>
        
        <?php foreach ($comments as $comment) { ?>
        <?php $sender = Database::get_instance()->get_user($comment->get_sender_name()); ?>

        <div class="comment">
            <div class="comment-header">
                <!-- <img src="<?= $sender->get_profile_picture_url() ?>" alt="profilkép" title="Avatar"
                    class="image pfp center-image image-fluid round-image fade-and-scale"> todo: make me pretty-->
                <p>
                    <?= $sender->get_name() ?>
                </p>
                <time datetime="<?= $comment->get_date() ?>">
                    <script>document.write(new Date(1000 * <?= $comment->get_date() ?>).toLocaleString())</script>
                </time>
            </div>
            <p>
                <?= $comment->get_message() ?>
            </p>
            <form action="profile?user=<?= $username ?>" method="POST"
                <?= ($session === null || ($session->get_name() != $comment->get_sender_name() && !$session->is_admin() && !$is_self)) ? "hidden" : "" ?> 
            >
                <input type="hidden" name="comment-message" value="<?= $comment->get_message() ?>">
                <input type="hidden" name="comment-date" value="<?= $comment->get_date() ?>">
                <input type="submit" name="delete-comment" value="🗑️">
            </form>
        </div>
        <hr>
        <?php } ?>

        <?php if (SessionManager::is_logged_in()) { ?>
        <h2>Új komment</h2>
        <form action="profile?user=<?= $username ?>" method="POST">
            <textarea name="message" id="message" cols="30" rows="10" placeholder="Üzenet"></textarea>
            <label for="message"><?= $comment_error ?></label> <!-- Please make this pretty -->
            <input type="submit" name="add-comment" value="Küldés">
        </form>
        <?php } else { ?>
        <p>Be kell jelentkezned, hogy kommentelhess!</p>
        <?php } ?>

    </main>

    <?php include "templates/footer.hidden.php"; ?>
</body>

</html>