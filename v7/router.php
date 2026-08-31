<?php
/* ============================================================
   router.php, only for the PHP built-in server:

       php -S localhost:8000 router.php

   The built-in server does not read .htaccess, so this
   reproduces the one rewrite rule the site needs:
   /resume  ->  /resume.php
   Real hosting (Apache/LiteSpeed) uses .htaccess and ignores
   this file completely.
   ============================================================ */

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// serve real files (css, js, images, json) exactly as they are
$file = __DIR__ . $path;
if ($path !== '/' && file_exists($file) && !is_dir($file)) {
    return false;
}

// "/" -> index.php
if ($path === '/') {
    require __DIR__ . '/index.php';
    return true;
}

// "/resume" -> resume.php
$candidate = __DIR__ . $path . '.php';
if (file_exists($candidate)) {
    require $candidate;
    return true;
}

// anything else: fall back to the home page instead of a blank 404
http_response_code(404);
require __DIR__ . '/index.php';
return true;
