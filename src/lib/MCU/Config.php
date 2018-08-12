<?php

namespace MCU;

class Config {

    private static $props = array();


    public static function set($key, $value) {
        self::$props[$key] = $value;
    }

    public static function get($key, $default = null) {
        if (isset(self::$props[$key])) {
            return self::$props[$key];
        }

        return $default;
    }

    public static function unset($key) {
        unset(self::$props[$key]);
    }
}