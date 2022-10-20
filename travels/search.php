<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

include_once '../config/database.php';
include_once '../models/travel.php';
include_once '../config/core.php';

$database = new Database();
$db = $database->getConnection();

$travel = new Travel($db);

// get keywords
$keywords=isset($_GET["q"] ) ? $_GET["q"] : "";


$stmt = $travel->search($keywords);
$num = $stmt->rowCount();


if($num>0){
    $travels_arr=array();
    $travels_arr["records"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $travel_item=array(
            "Id" => $Id,
            "Name" => $Name,
            "Description" => $Description,
            "Location" => $Location,
            "Attendees" => $Attendees,
            "Reference" => $Reference

        );

        array_push($travels_arr["records"], $travel_item);
    }

    http_response_code(200);
    echo json_encode($travels_arr);
}

else{

    http_response_code(404);
    echo json_encode(
        array("message" => "No travel has been found.")
    );
}
?>