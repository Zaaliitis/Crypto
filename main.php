<?php
require_once "vendor/autoload.php";

use App\ApiClient;
use App\Application;

$client = new ApiClient();
$app = new Application($client);
$app->run();



