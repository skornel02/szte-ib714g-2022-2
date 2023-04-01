<?php

class User {
    public string $name;
    public string $email;
    public string $password_hash;

    function __construct(string $name, string $email, string $password_hash) {
        $this->name = $name;
        $this->email = $email;
        $this->password_hash = $password_hash;
    }

    public static function from_dump(array $dump): User {
        return new User($dump["name"], $dump["email"], $dump["password_hash"]);
    }

    public function dump(): array {
        return [
            "name" => $this->name,
            "email" => $this->email,
            "password_hash" => $this->password_hash,
        ];
    }

    public function verify_password(string $password): bool {
        return password_verify($password, $this->password_hash);
    }
}

?>
