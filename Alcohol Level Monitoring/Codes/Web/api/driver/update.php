<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/drivermodel.php';
 
$database = new Database();
$db = $database->getConnection();
 
$drivermodel= new DriverModel($db);
 
// set product property values
$id= isset($_GET['id']) ? $_GET['id'] : die();
$drivermodel->license_number= isset($_GET['license_number']) ? $_GET['license_number'] : die();
$drivermodel->name= isset($_GET['name']) ? $_GET['name'] : die();
$drivermodel->address= isset($_GET['address']) ? $_GET['address'] : die();

// create the product
if($drivermodel->update($id)){
    echo '{';
        echo '"message": "success"';
    echo '}';
}
 
// if unable to create the product, tell the user
else{
    echo '{';
        echo '"message": "failed"';
    echo '}';
}
?>