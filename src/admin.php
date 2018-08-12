<?php


use HTTP\RequestHelper;
use MCU\Config;

session_start();

$_TEMPLATE = array();

function signedIn() {
    return isset($_SESSION["APP_LOGIN"]) && $_SESSION["APP_LOGIN"] ? true : false;
}

function checkLogin($pw, $modpack) {
    global $_TEMPLATE;

    if ($pw == Config::get("passwords.$modpack", null)) {
        $_SESSION["APP_LOGIN"]     = true;
        $_SESSION["APP_PACK"]      = $modpack;
        $_SESSION["LOGIN_ATTEMPT"] = 0;

        $_TEMPLATE["LOGIN_SUCCESS"] = true;
    }
}

function isPackAllowed() {
    $myPack = RequestHelper::getPathVariable(3, null);
    $perm   = $_SESSION["APP_PACK"];

    if ($myPack != null) {
        if ($perm == $myPack || $perm == "master") {
            return true;
        }
    }
    return false;
}

$action = RequestHelper::getPathVariable(2, null);

switch ($action) {
    default:
    case "login":
        break;
    case "choose-pack":
        break;
    case "logout":
        break;
}

if ($action == "login" || $action == null) {

    if (signedIn()) {
        header("Location: /index.php/admin/overview");
    }

    // login
    if (isset($_POST["password"])) {
        $pw = $_POST["password"];

        checkLogin($pw, "master");

        // increase login attempts
        if (!$_SESSION["APP_LOGIN"]) {
            $_SESSION["LOGIN_ATTEMPT"]++;
        }

        // ban on too much attempts
        if ($_SESSION["LOGIN_ATTEMPT"] > Config::get("max-login-attempts", 3)) {
            RequestHelper::banCurrentIp();
            session_destroy();
            header("Location: /index.php");
        }
    }

    include "template_admin/login.php";
} elseif ($action == "overview" && signedIn()) {
    include "template_admin/index.php";
} elseif ($action == "logout") {
    echo "dwd";
    $_SESSION["APP_LOGIN"]     = false;
    $_SESSION["LOGIN_ATTEMPT"] = 0;
    header("Location: login");
}