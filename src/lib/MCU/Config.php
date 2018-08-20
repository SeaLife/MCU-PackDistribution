<?php

namespace MCU;

/**
 * Class Config
 * @package MCU
 */
class Config {

    /** @var array */
    private static $props = array();


    public static function set ($key, $value) {
        self::$props[$key] = $value;
    }

    public static function get ($key, $default = NULL) {
        if (isset(self::$props[$key])) {
            return self::$props[$key];
        }

        return $default;
    }

    public static function unset ($key) {
        unset(self::$props[$key]);
    }
}