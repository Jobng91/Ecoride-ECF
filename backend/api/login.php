<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Database\DBConnection;
use App\Models\UserModel;
use App\Services\UserService;
use App\Services\AuthService;
use App\Controllers\LoginController;


$db = new DBConnection();
$model = new UserModel($db);
$userService = new UserService($model);
$authService = new AuthService($model);
$controller = new LoginController($userService, $authService);


$controller->login();