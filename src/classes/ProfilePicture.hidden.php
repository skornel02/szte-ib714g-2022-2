<?php

class ProfilePicture {
    public static function create_url_for_user(): string {
        do {
            $path = uniqid("user", true) . ".png";
        } while (file_exists("pfp/$path"));

        copy("assets/img/default-profilepicture.png", "pfp/$path");

        return "pfp/" . $path;
    }

    public static function update_profile_picture(
        string $username,
        $new_profile_picture
    ): string|null {
        $user = Database::get_instance()->get_user($username);
        if ($user == null) {
            return "Felhasználó nem található!";
        }
        $profile_picture_path = $user->get_profile_picture_url();

        if ($new_profile_picture["tmp_name"] == null) {
            return "Nem választottál ki képet.";
        }

        if (getimagesize($new_profile_picture["tmp_name"]) === false) {
            return "A fájl nem kép.";
        }

        if ($new_profile_picture["size"] > 2000000) {
            return "A kép mérete túl nagy.";
        }

        if (!rename($new_profile_picture["tmp_name"], $profile_picture_path)) {
            return "A kép feltöltése nem sikerült.";
        }

        return null;
    }

    public static function remove_profile_picture(string $username): void {
        $user = Database::get_instance()->get_user($username);
        if ($user == null) {
            return;
        }

        $profile_picture_path = $user->get_profile_picture_url();
        if (file_exists($profile_picture_path)) {
            unlink($profile_picture_path);
        }
    }
}

?>
