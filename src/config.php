<?php

use MCU\Config;


Config::set(
    "theme",
    orv($_ENV["APP_THEME"], "/template_xml/sealife.xsl")
);

Config::set(
    "app.password.admin",
    orv($_ENV["APP_MASTER_PASSWORD"], "KmSDUJrhS366FY5a")
);


$file = (isset($_ENV["COMPOSER_LOCATION"]) ? $_ENV["COMPOSER_LOCATION"] : "../") . "vendor/autoload.php";

if (!file_exists($file)) {
    die("Composer not installed/runned, run `install-twig.php`");
} else {
    /** @noinspection PhpIncludeInspection */
    include $file;
}