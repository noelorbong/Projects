<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/alcoholicmodel.php';
 
$database = new Database();
$db = $database->getConnection();
 
$alcoholicmodel= new AlcoholicModel($db);
 
// set product property values
$alcoholicmodel->license_number= isset($_GET['license_number']) ? $_GET['license_number'] : die();
$alcoholicmodel->name= isset($_GET['name']) ? $_GET['name'] : die();
$alcoholicmodel->address= isset($_GET['address']) ? $_GET['address'] : die();
$alcoholicmodel->alcohol_level= isset($_GET['alcohol_level']) ? $_GET['alcohol_level'] : die();

// create the product
if($alcoholicmodel->create()){
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