<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Database\DBConnection;
use App\Database\MongoDBConnection;

use App\Models\RideModel;
use App\Models\RideCounterModel;

use App\Services\RideService;
use App\Controllers\RideController;


$db = new DBConnection();
$rideModel = new RideModel($db);

$mongo = new MongoDBConnection();
$counterModel = new RideCounterModel($mongo->getClient());

$service = new RideService($rideModel, $counterModel);
$controller = new RideController($service);

$controller->getStats();
