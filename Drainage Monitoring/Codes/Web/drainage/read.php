<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/drainagemodel.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$drainagemodel = new DrainageModel($db);

$limit = isset($_GET['limit']) ? $_GET['limit'] : '100';

// query products
$stmt = $drainagemodel->read($limit);
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $drainagemodel_arr =array();
    $drainagemodel_arr["records"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $drainagemodel_item=array(
            "id" => $id,
            "temperature" => $temperature,
            "humidity" => $humidity,
            "water_level" => $water_level,
            "water_flow" => $water_flow,
            "created_at" => $created_at,
            "updated_at" => $updated_at
        );
 
        array_push($drainagemodel_arr["records"], $drainagemodel_item);
    }
 
    echo json_encode($drainagemodel_arr);
}
 
else{
    echo json_encode(
        array("message" => "No drainage data found.")
    );
}
?>