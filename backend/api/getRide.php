<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Database\DBConnection;
use App\Models\RideModel;
use App\Services\RideService;
use App\Controllers\RideController;

$db = new DBConnection();
$model = new RideModel($db);
$service = new RideService($model);
$controller = new RideController($service);

$controller->get();
