<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 

// include database and object files
include_once '../config/connection.php';
include_once '../objects/deliveries.php';
 
// instantiate database 
$connection = new Connection();
$db = $connection->getConnection();
 
// initialize object
$Deliveries = new Deliveries($db);
 
$data = json_decode(file_get_contents("php://input"));

if (!empty($data->deliveryId) && !empty($data->deliveryDate) && !empty($data->deliveryTime) && !empty($data->deliveryAddressId)) {

    $Deliveries->deliveryDate = $data->deliveryDate;
    $Deliveries->deliveryTime = $data->deliveryTime;
    $Deliveries->deliveryAddressId = $data->deliveryAddressId;
    $Deliveries->deliveryId = $data->deliveryId;
  

    if($returnVal = $Deliveries->update()){
        http_response_code(200);
        echo json_encode(array("Message" => "Success", "Status" => "200"));
    } else{
        http_response_code(500);
        echo json_encode(array("Message" => "Error", "Status" => "500"));
    }
    
} else {
    
    http_response_code(403);
    echo json_encode(array("Message" => "Insufficient or wrong parameters.", "Status" => "403"));

}

?>