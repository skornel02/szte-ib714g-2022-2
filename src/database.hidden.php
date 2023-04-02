<?php

class Database {
    private static ?Database $instance = null;

    /**
     * @var User[]
     */
    private ?array $users = null;

    public static function get_instance(): Database {
        if (self::$instance == null) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    /**
     * @return User[]
     */
    public function get_users(): array {
        if ($this->users == null) {
            $this->users = [];
            if (!file_exists("data/users.json")) {
                return $this->users;
            }

            $users_dump = json_decode(
                file_get_contents("data/users.json"),
                true
            );

            foreach ($users_dump as $user_dump) {
                array_push($this->users, User::from_dump($user_dump));
            }
        }

        return $this->users;
    }

    private function save_users(): void {
        $users_dump = [];

        foreach ($this->users as $user) {
            array_push($users_dump, $user->dump());
        }

        file_put_contents("data/users.json", json_encode($users_dump));
    }

    public function add_user(User $user): void {
        $this->get_users();
        array_push($this->users, $user);
        $this->save_users();
    }

    public function get_user(string $username): User|null {
        foreach ($this->get_users() as $user) {
            if ($user->get_name() == $username) {
                return $user;
            }
        }

        return null;
    }

    public function update_user(User $user): void {
        $this->get_users();

        for ($i = 0; $i < count($this->users); $i++) {
            if ($this->users[$i]->get_name() == $user->get_name()) {
                $this->users[$i] = $user;
                $this->save_users();
                return;
            }
        }
    }
}

?>
