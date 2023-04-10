<?php

spl_autoload_register(function ($class_name) {
    include $class_name . ".hidden.php";
});

class SessionManager {
    private static function start_session(): void {
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    public static function end_session(): void {
        SessionManager::start_session();
        $_SESSION["logged_in"] = false;
        $_SESSION["user"] = null;
        session_destroy();
    }

    public static function is_logged_in(): bool {
        SessionManager::start_session();

        return key_exists("logged_in", $_SESSION) && $_SESSION["logged_in"];
    }

    private static function get_property(string $key): string|null {
        SessionManager::start_session();

        return key_exists($key, $_SESSION) ? $_SESSION[$key] : null;
    }

    public static function login(User $user): void {
        SessionManager::start_session();

        $_SESSION["logged_in"] = true;
        $_SESSION["user"] = $user->get_name();
    }

    public static function get_session(): User|null {
        SessionManager::start_session();

        if (!SessionManager::is_logged_in()) {
            return null;
        }

        return Database::get_instance()->get_user(
            SessionManager::get_property("user")
        );
    }

    public static function is_admin(): bool {
        $session = SessionManager::get_session();

        return $session != null && $session->is_admin();
    }
}

?>
