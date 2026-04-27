<?php

/**
 * Get the base path
 * 
 * @param string $path 
 * @return string
 */
function basePath($path = '') {
    return __DIR__ . '/' . $path;
}

/**
 * Load a view
 * 
 * @param string $name
 * @return void`
 * 
 */
function loadView($name) {
    require basePath("views/{$name}.view.php");
}

/**
 * Load a Partial
 * 
 * @param string $name
 * @return void`
 * 
 */
function loadPartial($name) {
    require basePath("views/partials/{$name}.php");
}