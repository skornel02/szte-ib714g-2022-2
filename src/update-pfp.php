<?php
require_once "session.hidden.php";

if (!SessionManager::is_logged_in() || $_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: login");
    exit();
}

$profile_picture_path = SessionManager::get_session()->get_profile_picture_url();
rename("pfp/$profile_picture_path", "pfp/$profile_picture_path.old");
$new_profile_picture = $_FILES["profile-picture"];
$pfp_error = ProfilePicture::update_profile_picture(
    SessionManager::get_session()->get_name(),
    $new_profile_picture
);

header("Location: settings?pfp-error=$pfp_error");

?>
