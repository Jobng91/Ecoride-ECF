<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Database\DBConnection;
use App\Models\UserModel;
use App\Services\AuthService;
use App\Controllers\MeController;


$db = new DBConnection();
$model = new UserModel($db);
$authService = new AuthService($model);
$controller = new MeController($authService);


$controller->show();
