<?php
/** @noinspection PhpIncludeInspection */

spl_autoload_register(function ($name) {
    $name = str_replace("\\", "/", $name);

    if (file_exists("lib/$name.php")) {
        include "lib/$name.php";
    } else if (file_exists("lib/$name.class.php")) {
        include "lib/$name.class.php";
    }
});

function orv ($val, $or) {
    if (!isset($val) || empty($val)) {
        return $or;
    }
    return $val;
}

include "config.php";
include "app.php";