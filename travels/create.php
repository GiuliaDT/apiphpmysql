<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../models/travel.php';
include_once '../config/core.php';

$database = new Database();
$db = $database->getConnection();

$travel = new Travel($db);

$data = json_decode(file_get_contents("php://input"));


if(
    !empty($data->Name) &&
    !empty($data->Description) &&
    !empty($data->Location) &&
    !empty($data->Attendees) &&
    !empty($data->Reference)

){

    $travel->Name = $data->Name;
    $travel->Description = $data->Description;
    $travel->Location = $data->Location;
    $travel->Attendees = $data->Attendees;
    $travel->Reference = $data->Reference;
    if($travel->create()){
        http_response_code(201);
        echo json_encode(array("message" => "Travel was created."));
    }

    else{
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create travel."));
    }
}

else{

    http_response_code(400);

    echo json_encode(array("message" => "Unable to procceed. Data is incomplete."));
}
?>