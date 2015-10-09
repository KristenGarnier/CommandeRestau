<?php

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application();

include '../app/config/bootstrap.php';

$app->run();