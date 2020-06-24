<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/trackermodel.php';
 
$database = new Database();
$db = $database->getConnection();
 
$trackermodel= new TrackerModel($db);
 
// set product property values
$trackermodel->latitude= isset($_GET['latitude']) ? $_GET['latitude'] : die();
$trackermodel->longitude= isset($_GET['longitude']) ? $_GET['longitude'] : die();
$trackermodel->car_shock= isset($_GET['car_shock']) ? $_GET['car_shock'] : die();
 
// create the product
if($trackermodel->create()){
    echo '{';
        echo '"message": "Tracker data was created."';
    echo '}';
}
 
// if unable to create the product, tell the user
else{
    echo '{';
        echo '"message": "Unable to create Tracker data."';
    echo '}';
}
?>