<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/drivermodel.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$drivermodel= new DriverModel($db);

$lisence_num = isset($_GET['lisence_num']) ? $_GET['lisence_num'] : die();

// query products
$stmt = $drivermodel->check($lisence_num);
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
     echo json_encode(
        array("count" => $num)
    );
}
else{
    echo json_encode(
        array("count" => 0)
    );
}
?>