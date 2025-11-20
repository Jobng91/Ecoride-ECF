<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Database\DBConnection;
use App\Models\UserModel;
use App\Services\UserService;
use App\Controllers\UserController;


$db = new DBConnection();
$model = new UserModel($db);
$service = new UserService($model);
$controller = new UserController($service);


$controller->register();
