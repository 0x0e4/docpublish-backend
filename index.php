<?php

require_once __DIR__ . '/vendor/autoload.php';

use Pecee\SimpleRouter\SimpleRouter;

require_once (__DIR__ . '/routes/routes.php');

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: X-Requested-With, content-type');
header('Access-Control-Allow-Methods: OPTIONS');    
header('Access-Control-Allow-Credentials: true');

SimpleRouter::start();