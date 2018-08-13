<?php

use MCU\Config;


Config::set(
    "theme",
    orv($_ENV["APP_THEME"], "sealife.xsl")
);

Config::set(
    "passwords.master",
    orv($_ENV["APP_MASTER_PASSWORD"], "KmSDUJrhS366FY5a")
);