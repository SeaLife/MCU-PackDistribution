<?php

set_time_limit(0);

ini_set("phar.readonly", FALSE);

if (!Phar::canWrite()) {
    print("Run this file from CLI with: php -dphar.readonly=0 build.php");
    die(1);
}

$phar = new Phar("mcu.phar");
$phar->buildFromDirectory("src/");
$phar->setStub(Phar::createDefaultStub("index.php", "index.php"));
/*$phar->setStub('<?php Phar::interceptFileFuncs(); Phar::mungServer(array("REQUEST_URI")); Phar::webPhar(); __HALT_COMPILER(); ?>');*/