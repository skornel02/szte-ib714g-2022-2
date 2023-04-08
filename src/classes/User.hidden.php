<?php

require_once "profilepicture.hidden.php";

class User {
    private string $name;
    private string $email;
    private string $password_hash;
    private string $profile_picture_url;
    private int $last_logged_in;
    private string $description;
    private bool $is_private;
    private bool $is_admin;

    function __construct(
        string $name,
        string $email,
        string $password_hash,
        string $profile_picture_url,
        int $last_logged_in,
        string $description,
        bool $is_private,
        bool $is_admin
    ) {
        $this->name = $name;
        $this->email = $email;
        $this->password_hash = $password_hash;
        $this->profile_picture_url = $profile_picture_url;
        $this->last_logged_in = $last_logged_in;
        $this->description = $description;
        $this->is_private = $is_private;
        $this->is_admin = $is_admin;
    }

    public static function hash_password(string $password): string {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function create_new(
        string $username,
        string $email,
        string $password
    ): User {
        return new User(
            $username,
            $email,
            User::hash_password($password),
            ProfilePicture::create_url_for_user(),
            time(),
            "-",
            true,
            false
        );
    }

    public static function from_dump(array $dump): User {
        return new User(
            $dump["name"],
            $dump["email"],
            $dump["password_hash"],
            $dump["profile_picture_url"],
            $dump["last_logged_in"] ?? 0,
            $dump["description"] ?? "",
            $dump["is_private"] ?? true,
            $dump["is_admin"] ?? false
        );
    }

    public function dump(): array {
        return [
            "name" => $this->name,
            "email" => $this->email,
            "password_hash" => $this->password_hash,
            "profile_picture_url" => $this->profile_picture_url,
            "last_logged_in" => $this->last_logged_in,
            "description" => $this->description,
            "is_private" => $this->is_private,
            "is_admin" => $this->is_admin,
        ];
    }

    public function verify_password(string $password): bool {
        return password_verify($password, $this->password_hash);
    }

    public function update_password(string $new_password): void {
        $this->password_hash = User::hash_password($new_password);
    }

    public function get_name(): string {
        return $this->name;
    }

    public function get_email(): string {
        return $this->email;
    }

    public function get_profile_picture_url(): string {
        return $this->profile_picture_url;
    }

    public function get_last_logged_in(): int {
        return $this->last_logged_in;
    }

    public function set_last_logged_in(int $last_logged_in): void {
        $this->last_logged_in = $last_logged_in;
    }

    public function get_description(): string {
        return $this->description;
    }

    public function set_description(string $description): void {
        $this->description = $description;
    }

    public function is_private(): bool {
        return $this->is_private;
    }

    public function set_private(bool $is_private): void {
        $this->is_private = $is_private;
    }

    public function is_admin(): bool {
        return $this->is_admin;
    }

    public function set_admin(bool $is_admin): void {
        $this->is_admin = $is_admin;
    }
}

?>
