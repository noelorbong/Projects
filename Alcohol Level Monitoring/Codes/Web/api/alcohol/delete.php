<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/alcoholmodel.php';
 
$database = new Database();
$db = $database->getConnection();
 
$alcoholmodel= new AlcoholModel($db);
 
// set product property values
$id= isset($_GET['id']) ? $_GET['id'] : die();

// create the product
if($alcoholmodel->delete($id)){
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