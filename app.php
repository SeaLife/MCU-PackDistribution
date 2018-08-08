<?php
/** @noinspection SpellCheckingInspection */


use MCU\ModPackReader;

header('Content-Type: text/xml');


$reader = new ModPackReader("./");
echo $reader->output();