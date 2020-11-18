<?php

use App\Database\MysqlConnector;
use App\Kernel;
use App\Middleware\AuthorizationCheck;

require __DIR__ . "/vendor/autoload.php";

/** @var Kernel $application */
$application = app()->make(Kernel::class);

$application->addMiddleware(app()->make(AuthorizationCheck::class));

$application->run();