<?php
/** @noinspection SpellCheckingInspection */

use MCU\ModPackReader;

header('Content-Type: text/xml');

if(!isset($_ENV["BASE_URL"])) {
    $_ENV["BASE_URL"] = "https://mc.r3ktm8.de";
}

$reader = new ModPackReader("modpacks/");
echo $reader->output();