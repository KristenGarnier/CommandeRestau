<?php

$debug = $app['config']->getDebugConfig();

$app['debug'] = $debug['dev'];