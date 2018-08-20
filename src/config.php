<?php

use MCU\Config;

class ConfigKeys {
    const THEME           = "theme";
    const MASTER_PASSWORD = "app.password.admin";
}


Config::set(
    ConfigKeys::THEME,
    orv($_ENV["APP_THEME"], "/template_xml/sealife.xsl")
);

Config::set(
    ConfigKeys::MASTER_PASSWORD,
    orv($_ENV["APP_MASTER_PASSWORD"], "KmSDUJrhS366FY5a")
);