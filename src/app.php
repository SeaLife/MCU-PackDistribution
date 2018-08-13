<?php
/** @noinspection SpellCheckingInspection */

use HTTP\RequestHelper;
use MCU\ModPackReader;

if (RequestHelper::currentIpBanned()) {
    http_response_code(401);
    print(json_encode(array("code" => 401, "message" => "IP banned")));
    die(1);
}

if (RequestHelper::getPathVariable(1) == "admin") {
    include "admin.php";
} else {
    header('Content-Type: text/xml');

    $_ENV["BASE_URL"] = orv($_ENV["BASE_URL"], "https://localhost:8000");

    $reader = new ModPackReader("modpacks/");
    echo $reader->output();
}