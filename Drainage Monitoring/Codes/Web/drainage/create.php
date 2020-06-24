<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/drainagemodel.php';
 
$database = new Database();
$db = $database->getConnection();
 
$drainagemodel = new DrainageModel($db);
 
// set product property values
$drainagemodel->temperature = isset($_GET['temperature']) ? $_GET['temperature'] : die();
$drainagemodel->humidity = isset($_GET['humidity']) ? $_GET['humidity'] : die();
$drainagemodel->water_level = isset($_GET['water_level']) ? $_GET['water_level'] : die();
$drainagemodel->water_flow = isset($_GET['water_flow']) ? $_GET['water_flow'] : die();
 
// create the product
if($drainagemodel->create()){
    echo '{';
        echo '"message": "Drainage data was created."';
    echo '}';
}
 
// if unable to create the product, tell the user
else{
    echo '{';
        echo '"message": "Unable to create Drainage data."';
    echo '}';
}
?>