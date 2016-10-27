<?php

/*
 * ikobi singleton and factory design pattern implementation
 */

class factory {
    public static function get($name, $param = null, $path = '/include', $dr = DR) {
        static $ram = array();

        $code = $name . ($param ? (is_array($param) ? '_' . implode('_', $param) : '_' . $param) : '');
        return isset($ram[$code]) ? $ram[$code] : ($ram[$code] = self::create($name, $param, $path, $dr));
    }

    public static function create($name, $param = null, $path = '/include', $dr = DR) {
        self::add($name, $path, $dr);
        return empty($param) ? new $name : new $name($param);
    }

    public static function add($name, $path = '/include', $dr = DR) {
        if ($filename = file_exists($dr . $path . '/' . $name . '.php') ? $name : (file_exists($dr . $path . '/class.' . $name . '.php') ? 'class.' . $name : 0)) {
            require_once $dr . $path . '/' . $filename . '.php';
        } else {
            exit($name . ' class not found!');
        }

    }
}