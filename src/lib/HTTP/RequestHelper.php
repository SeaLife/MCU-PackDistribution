<?php

namespace HTTP;

class RequestHelper {
    public static function getPathVariable($idx, $default = null) {
        $path = $_SERVER["REQUEST_URI"];

        $idx++;

        $items = explode("/", $path);

        if (isset($items[$idx])) {
            return $items[$idx];
        } else {
            return $default;
        }
    }

    public static function currentIpBanned() {
        $remoteAddr = $_SERVER["REMOTE_ADDR"];

        $ips = explode("\n", file_get_contents("banip.txt"));

        return in_array($remoteAddr, $ips);
    }

    public static function banCurrentIp() {
        $ips = file_get_contents("banip.txt");
        $ips .= $_SERVER["REMOTE_ADDR"] . "\n";

        file_put_contents("banip.txt", $ips);
    }
}