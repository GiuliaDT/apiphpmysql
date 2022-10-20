<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../models/travel.php';
include_once '../config/core.php';

$database = new Database();
$db = $database->getConnection();


$travel = new Travel($db);

$travel->id = isset($_GET['id']) ? $_GET['id'] : die();
$travel->readSingle();

if($travel->name!=null){

    $travel_arr = array(
        "id" =>  $travel->id,
        "name" => $travel->name,
        "description" => $travel->description,
        "location" => $travel->location,
        "attendees" => $travel->attendees,
        "reference" => $travel->reference

    );

    http_response_code(200);
    echo json_encode($travel_arr);
}

else{
    http_response_code(404);
    echo json_encode(array("message" => "Travel does not exist."));
}
?>