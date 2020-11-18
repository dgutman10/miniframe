<?php

if (!function_exists("app")) {
    function app() {
        return \App\Container::getInstance();
    }
}

if (!function_exists("config")) {
    function config($key) {
        $config = require __DIR__ . "/../config/config.php";
        $keys = explode(".", $key);

        foreach ($keys as $key) {
            $config = &$config[$key];
        }

        return $config;
    }

}