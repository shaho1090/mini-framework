<?php

use App\App;

require __DIR__.'/../vendor/autoload.php';

$app = App::getInstance();
$app->run();