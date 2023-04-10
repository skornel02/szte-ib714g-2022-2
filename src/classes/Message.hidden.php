<?php

class Message {
    private string $message;
    private string $sender_name;
    private string $receiver_name;
    private int $date;
    private bool $seen;

    public function __construct(
        string $message,
        string $sender_name,
        string $receiver_name,
        int $date,
        bool $seen
    ) {
        $this->message = $message;
        $this->sender_name = $sender_name;
        $this->receiver_name = $receiver_name;
        $this->date = $date;
        $this->seen = $seen;
    }

    public static function create_new(
        string $message,
        string $sender_name,
        string $receiver_name
    ): Message {
        return new Message(
            $message,
            $sender_name,
            $receiver_name,
            time(),
            false
        );
    }

    public static function from_dump(array $dump): Message {
        return new Message(
            $dump["message"],
            $dump["sender_name"],
            $dump["receiver_name"],
            $dump["date"],
            $dump["seen"]
        );
    }

    public function dump(): array {
        return [
            "message" => $this->message,
            "sender_name" => $this->sender_name,
            "receiver_name" => $this->receiver_name,
            "date" => $this->date,
            "seen" => $this->seen,
        ];
    }

    public function get_message(): string {
        return $this->message;
    }

    public function get_sender_name(): string {
        return $this->sender_name;
    }

    public function get_receiver_name(): string {
        return $this->receiver_name;
    }

    public function get_date(): int {
        return $this->date;
    }

    public function get_seen(): bool {
        return $this->seen;
    }

    public function set_seen(bool $seen): void {
        $this->seen = $seen;
    }
}

?>
