<?php

if (!isset($_SESSION)) {
    session_start();
}

function is_logged_in(): bool {
    return key_exists("logged_in", $_SESSION) && $_SESSION["logged_in"];
}

?>
