<?php

namespace Core;

class Autoloader
{
    public static function register()
    {
        spl_autoload_register(function ($class) {
            // Tentukan base directory untuk namespace `App` dan `Core`
            $prefixes = [
                'App\\' => __DIR__ . '/../app/',
                'Core\\' => __DIR__ . '/'
            ];

            // Cari prefix yang sesuai dengan class yang diminta
            foreach ($prefixes as $prefix => $baseDir) {
                // Cek apakah class dimulai dengan prefix yang sesuai
                if (strncmp($prefix, $class, strlen($prefix)) === 0) {
                    // Buat nama file relatif untuk class
                    $relativeClass = substr($class, strlen($prefix));
                    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

                    // Jika file ada, load file tersebut
                    if (file_exists($file)) {
                        require $file;
                        return;
                    }
                }
            }
        });
    }
}
