<?php

include 'services.php';

include 'db.php';

$app->register(new Whoops\Provider\Silex\WhoopsServiceProvider);

include 'debug.php';

include 'routes.php';

include 'security.php';