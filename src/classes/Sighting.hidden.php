<?php
class Sighting {
    private int $timestamp;
    private float $certainty;
    private string $country;
    private string $type;

    private string $username;

    public function __construct(
        int $timestamp,
        float $certainty,
        string $country,
        string $type,
        string $username
    ) {
        $this->timestamp = $timestamp;
        $this->certainty = $certainty;
        $this->country = $country;
        $this->type = $type;
        $this->username = $username;
    }

    public static function create_new(
        int $timestamp,
        float $certainty,
        string $country,
        string $type,
        User $user
    ): Sighting {
        return new Sighting(
            $timestamp,
            $certainty,
            $country,
            $type,
            $user->get_name()
        );
    }

    public static function from_dump(array $dump): Sighting {
        return new Sighting(
            $dump["timestamp"],
            $dump["certainty"],
            $dump["country"],
            $dump["type"],
            $dump["username"]
        );
    }

    public function dump(): array {
        return [
            "timestamp" => $this->timestamp,
            "certainty" => $this->certainty,
            "country" => $this->country,
            "type" => $this->type,
            "username" => $this->username,
        ];
    }

    public function get_timestamp(): int {
        return $this->timestamp;
    }

    public function get_certainty(): float {
        return $this->certainty;
    }

    public function get_country(): string {
        return $this->country;
    }

    public function get_type(): string {
        return $this->type;
    }

    public function get_username(): string {
        return $this->username;
    }
}

?>
