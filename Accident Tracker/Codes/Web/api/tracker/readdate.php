<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/trackermodel.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$trackermodel= new TrackerModel($db);

$startdate = isset($_GET['startdate']) ? $_GET['startdate'] : die();
$enddate= isset($_GET['enddate']) ? $_GET['enddate'] : die();

// query products
$stmt = $trackermodel->readbydate($startdate, $enddate);
$num = $stmt->rowCount();


// check if more than 0 record found
if($num>0){
 
    // products array
    $trackermodel_arr =array();
    $trackermodel_arr["records"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $trackermodel_item=array(
            "id" => $id,
            "latitude" => $latitude,
            "longitude" => $longitude,
            "car_shock" => $car_shock,
            "created_at" => $created_at,
            "updated_at" => $updated_at
        );
 
        array_push($trackermodel_arr["records"], $trackermodel_item);
    }
 
    echo json_encode($trackermodel_arr);
}
 
else{
    echo json_encode(
        array("message" => "No trackerdata found.")
    );
}
?>