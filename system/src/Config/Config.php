<?php

namespace Phplite\Config;

use Phplite\File\File;

class Config {
    private static $config;

    public static function init(){
        $config_files = File::glob('config', '*.php');
        foreach ($config_files as $file) {
            $name = str_replace(['/', '.php'], '', last(explode('/', $file)));
            self::$config[$name] = require $file;
        }
    }

    /**
     * get a config
     * 
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get(string $key, mixed $default = null){
        $values = explode('.', $key);
        $config = self::$config;

        foreach ($values as $key) {
            if (!isset($config[$key])) {
                // return $default;
                throw new \ErrorException("Key $key not found");
            }

            $config = $config[$key];
        }

        return $config ?? $default;
    }
}