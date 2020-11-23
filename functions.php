<?php

use Composer\Autoload\ClassLoader;

use MT\Theme;
use MT\Editors;
use MT\Templates\Layout;
use MT\Templates\Comments;
use MT\Templates\Search;

$autoload_ns = 'MT\\';
$autoload_dir = __DIR__ . '/src/';

try {
    $loader = new ClassLoader();
    $loader->addPsr4($autoload_ns , $autoload_dir);
    $loader->register();
    
} catch (Exception $e) {
    
    // Composer is not available, fallback to a custom SPL autoloader.
    spl_autoload_register(function ($class) use ($autoload_ns, $autoload_dir) {
        $ns_length = strlen($autoload_ns);
        if (strncmp($autoload_ns, $class, $ns_length) !== 0) {
            return;
        }
        
        $class_in_ns = substr($class, $ns_length);
        $file_in_dir = $autoload_dir . str_replace('\\', '/', $class_in_ns) . '.php';
        
        if (false === $realpath = realpath($file_in_dir)) {
            return;
        }
    
        require $realpath;
    });
    
}

Theme::setup();
Editors::setup();

Layout::setup();

Search::setup();
Comments::setup();
