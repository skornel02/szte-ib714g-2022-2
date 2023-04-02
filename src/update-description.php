<?php
require_once "session.hidden.php";

if (!SessionManager::is_logged_in() || $_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: login");
    exit();
}

$user = SessionManager::get_session();
if ($user == null) {
    header("Location: login");
    exit();
}

$description = $_POST["description"] ?? "";
$description_error = null;

if (strlen($description) > 300) {
    $description_error = "A leírás túl hosszú!";
} else {
    $user->set_description($description);
    Database::get_instance()->update_user($user);
}

header("Location: settings?desc-error=$description_error");

?>
