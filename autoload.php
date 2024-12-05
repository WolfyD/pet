<?php

spl_autoload_register(function ($class) {
    $prefix = 'PET';
    $base_dir = __DIR__ . '/resources/';

    // Check if the class uses the namespace prefix
    if (strpos($class, $prefix) === 0) {
        // Replace the namespace prefix with the base directory
        $relative_class = substr($class, strlen($prefix));
        $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

        // Include the file if it exists
        if (file_exists($file)) {
            require $file;
        }
    }
});
