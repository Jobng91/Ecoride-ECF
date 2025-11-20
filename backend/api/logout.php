<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Database\DBConnection;
use App\Models\UserModel;
use App\Services\AuthService;
use App\Controllers\LogoutController;

$db = new DBConnection();
$model = new UserModel($db);
$authService = new AuthService($model);
$controller = new LogoutController($authService);


$controller->logout();
