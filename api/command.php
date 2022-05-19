<?php


declare(strict_types=1);

http_response_code(500);
require __DIR__ . '/vendor/autoload.php';

$config = parse_ini_file("./config/settings.ini");


new \App\App($config, null);





