<?php
spl_autoload_register(function ($class_name) {
    require "classes/" . $class_name . ".hidden.php";
});

if (!SessionManager::is_logged_in() || $_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: login?error=Jelentkezz be először!");
    exit();
}

$action = $_POST["action"];

switch ($action) {
    case ProfileAction::UpdateProfilePicture->name:
        handle_profile_picture_update();
        break;
    case ProfileAction::UpdateDescription->name:
        handle_description_update();
        break;
    case ProfileAction::UpdateVisibility->name:
        handle_update_visibility();
        break;
    case ProfileAction::DeleteProfile->name:
        handle_delete_profile();
        break;
    default:
        header("Location: settings?error=Ismeretlen profil művelet!");
        break;
}

function user_session_helper(User $user): User
{
    if ($user == null) {
        header("Location: login?error=Jelentkezz be először!");
        exit();
    }
    return $user;
}

function handle_profile_picture_update()
{
    $user = user_session_helper(SessionManager::get_session());

    $new_profile_picture = $_FILES["profile-picture"];
    $pfp_error = ProfilePicture::update_profile_picture(
        $user->get_name(),
        $new_profile_picture
    );

    header("Location: settings?pfp-error=$pfp_error");
}

function handle_description_update()
{
    $user = user_session_helper(SessionManager::get_session());

    $description = $_POST["description"] ?? "";
    $description_error = null;

    if (strlen($description) > 300) {
        $description_error = "A leírás túl hosszú!";
    } else {
        $user->set_description($description);
        Database::get_instance()->update_user($user);
    }

    header("Location: settings?desc-error=$description_error");
}

function handle_delete_profile()
{
    $user = user_session_helper(SessionManager::get_session());

    $password = $_POST["password"] ?? "";
    if ($user->verify_password($password)) {
        Database::get_instance()->remove_user($user);
        SessionManager::end_session();
        header("Location: .?error=Sikeresen törölted a fiókodat!");
        exit();
    } else {
        header("Location: settings?remove-error=Hibás jelszó!");
    }
}

function handle_update_visibility()
{
    $user = user_session_helper(SessionManager::get_session());

    $visibility = $_POST["visible"] === "on";

    $user->set_private(!$visibility);
    Database::get_instance()->update_user($user);

    header("Location: settings");
}
?>