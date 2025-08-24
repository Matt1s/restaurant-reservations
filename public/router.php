<?php
// GitHub Pages PHP configuration
// This file helps with routing on static hosting platforms

// Get the request URI
$request = $_SERVER['REQUEST_URI'];

// Remove query string
$path = parse_url($request, PHP_URL_PATH);

// If the path doesn't exist as a file and doesn't end in .php, try to route it to index.php
if (!file_exists(__DIR__ . $path) && !str_ends_with($path, '.php')) {
    // Route everything through Laravel's index.php
    include __DIR__ . '/index.php';
    exit;
}
?>
