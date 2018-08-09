<?php

spl_autoload_register(function ($name) {
    $name = str_replace("\\", "/", $name);

    if (file_exists("$name.php")) {
        include "$name.php";
    } else if (file_exists("$name.class.php")) {
        include "$name.class.php";
    }
});

include "app.php";