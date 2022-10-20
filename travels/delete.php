<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../models/travel.php';
include_once '../config/core.php';

$database = new Database();
$db = $database->getConnection();

$travel = new Travel($db);
$data = json_decode(file_get_contents("php://input"));

$travel->Id = $data->Id;

if($travel->delete()) {
    http_response_code(200);
    echo json_encode(array("message" => "Travel was deleted."));
}
else{
    http_response_code(503);
    echo json_encode(array("message" => "Unable to delete travel."));
}
?>