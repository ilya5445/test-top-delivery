<?php

require "./vendor/autoload.php";

use Dotenv\Dotenv;
use API\Route;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$route = new Route;
$route->run();