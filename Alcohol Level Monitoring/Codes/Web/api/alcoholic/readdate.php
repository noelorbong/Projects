<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/alcoholicmodel.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$alcoholicmodel= new AlcoholicModel($db);

$startdate = isset($_GET['startdate']) ? $_GET['startdate'] : die();
$enddate= isset($_GET['enddate']) ? $_GET['enddate'] : die();

// query products
$stmt = $alcoholicmodel->readbydate($startdate, $enddate);
$num = $stmt->rowCount();


// check if more than 0 record found
if($num>0){
 
    // products array
    $alcoholicmodel_arr =array();
    $alcoholicmodel_arr["records"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $alcoholicmodel_item=array(
            "id" => $id,
            "license_number" => $license_number,
            "name" => $name,
            "address" => $address,
            "alcohol_level" => $alcohol_level,
            "created_at" => $created_at,
            "updated_at" => $updated_at
        );
 
        array_push($alcoholicmodel_arr["records"], $alcoholicmodel_item);
    }
 
    echo json_encode($alcoholicmodel_arr);
}
 
else{
    echo json_encode(
        array("message" => "No data found.")
    );
}
?>