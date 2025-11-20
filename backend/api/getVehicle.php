<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Database\DBConnection;
use App\Models\VehicleModel;
use App\Services\VehicleService;
use App\Controllers\VehicleController;



$db = new DBConnection();
$model = new VehicleModel($db);
$service = new VehicleService($model);
$controller = new VehicleController($service);

$controller->get();
