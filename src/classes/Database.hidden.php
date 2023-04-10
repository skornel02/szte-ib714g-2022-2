<?php

class Database {
    private static ?Database $instance = null;

    /**
     * @var User[]
     */
    private ?array $users = null;

    /**
     * @var Sighting[]
     */
    private ?array $sightings = null;

    /**
     * @var Message[]
     */
    private ?array $messages = null;

    private function __construct() {
        if (!file_exists("data")) {
            mkdir("data");
        }
    }

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
            if (!file_exists("data/.users.json")) {
                return $this->users;
            }

            $users_dump = json_decode(
                file_get_contents("data/.users.json"),
                true
            );

            foreach ($users_dump as $user_dump) {
                $this->users[] = User::from_dump($user_dump);
            }
        }

        return $this->users;
    }

    private function save_users(): void {
        $users_dump = [];

        foreach ($this->users as $user) {
            $users_dump[] = $user->dump();
        }

        file_put_contents(
            "data/.users.json",
            json_encode($users_dump, JSON_PRETTY_PRINT)
        );
    }

    public function add_user(User $user): void {
        $this->get_users();
        array_push($this->users, $user);
        $this->save_users();
    }

    public function get_user(string $username): User|null {
        $this->get_users();

        foreach ($this->users as $user) {
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

    public function remove_user(User $user): void {
        $this->get_users();

        for ($i = 0; $i < count($this->users); $i++) {
            if ($this->users[$i]->get_name() == $user->get_name()) {
                array_splice($this->users, $i, 1);
                $this->save_users();
                return;
            }
        }
    }

    /**
     * @return Sighting[]
     */
    public function get_sightings(): array {
        if ($this->sightings == null) {
            $this->sightings = [];
            if (!file_exists("data/.sightings.json")) {
                return $this->sightings;
            }

            $sightings_dump = json_decode(
                file_get_contents("data/.sightings.json"),
                true
            );

            foreach ($sightings_dump as $sighting_dump) {
                $this->sightings[] = Sighting::from_dump($sighting_dump);
            }
        }

        return $this->sightings;
    }

    /**
     * @return Sighting[]
     */
    public function get_sightings_by_user(string $username): array {
        $this->get_sightings();
        $sightings = [];

        foreach ($this->sightings as $sighting) {
            if ($sighting->get_username() == $username) {
                $sightings[] = $sighting;
            }
        }

        return $sightings;
    }

    public function save_sightings(): void {
        $sightings_dump = [];

        foreach ($this->sightings as $sighting) {
            $sightings_dump[] = $sighting->dump();
        }

        file_put_contents(
            "data/.sightings.json",
            json_encode($sightings_dump, JSON_PRETTY_PRINT)
        );
    }

    public function add_sighting(Sighting $sighting): void {
        $this->get_sightings();
        array_push($this->sightings, $sighting);
        $this->save_sightings();
    }

    public function remove_sighting(Sighting $sighting): void {
        $this->get_sightings();

        for ($i = 0; $i < count($this->sightings); $i++) {
            if (
                $this->sightings[$i]->get_timestamp() ==
                    $sighting->get_timestamp() &&
                $this->sightings[$i]->get_username() ==
                    $sighting->get_username()
            ) {
                array_splice($this->sightings, $i, 1);
                $this->save_sightings();
                return;
            }
        }
    }
}

?>
