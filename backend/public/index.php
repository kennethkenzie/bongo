<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Silence PHP 8.5+ deprecation notices emitted by vendor code
// (e.g. PDO::MYSQL_ATTR_SSL_CA) until upstream releases a patched version.
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../vendor/autoload.php';

(require_once __DIR__.'/../bootstrap/app.php')
    ->handleRequest(Request::capture());
