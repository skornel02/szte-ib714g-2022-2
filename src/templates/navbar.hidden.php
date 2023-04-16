<?php
$success = $_GET["success"] ?? null;
$error = $_GET["error"] ?? null;

function create_attributes_for_link($path) {
    $href = $path;
    $class = "";

    if (
        ($path == "." && str_ends_with($_SERVER["REQUEST_URI"], "/")) ||
        ($path != "." && strpos($_SERVER["REQUEST_URI"], '/' . $path) !== false)
    ) {
        $href = "#top";
        $class = "active";
    }

    return "href=\"$href\" class=\"$class\"";
}
function create_link_for_login() {
    $logged_in = SessionManager::is_logged_in();
    $attributes = $logged_in
        ? create_attributes_for_link("logout")
        : create_attributes_for_link("login");
    $name = $logged_in ? "Kijelentkezés" : "Bejelentkezés";

    return "<li><a $attributes> $name </a></li>";
}

function create_hidden_attribute($should_be_hidden) {
    return $should_be_hidden ? "hidden" : "";
}
?>

<nav id="top">
    <ul>
        <li>
            <a <?= create_attributes_for_link(".") ?>>Bevezető</a>
        </li>
        <li>
            <a <?= create_attributes_for_link("finder") ?>>Hol jár a pápa?</a>
        </li>
        <li>
            <a <?= create_attributes_for_link("leaderboard") ?>>Ranglétra</a>
        </li>
        <li <?= create_hidden_attribute(!SessionManager::is_logged_in()) ?>>
            <a <?= create_attributes_for_link(
                "profile?user=" .
                    (SessionManager::is_logged_in()
                        ? SessionManager::get_session()->get_name()
                        : "")
            ) ?>
            >profilom</a>
        </li>
        <li <?= create_hidden_attribute(!SessionManager::is_admin()) ?>>
            <a <?= create_attributes_for_link("admin") ?>>Admin</a>
        </li>
        <?= create_link_for_login() ?>
    </ul>
    <div class="toast-container">
        <?= "<div id=\"success-toaster\" class=\"toast\" onclick=\"disappearSuccessToaster();\">$success</div>" ?>
        <?= "<div id=\"error-toaster\" class=\"toast\" onclick=\"disappearErrorToaster();\">$error</div>" ?>
    </div>
</nav>

<script>
    setTimeout(() => {
        disappearSuccessToaster();
        disappearErrorToaster();
    }, 5000);
    
    function disappearSuccessToaster() {
        document.getElementById("success-toaster").classList.add("hidden");
    }

    function disappearErrorToaster() {
        document.getElementById("error-toaster").classList.add("hidden");
    }
</script>