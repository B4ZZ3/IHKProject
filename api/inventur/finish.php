<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once '../config/database.php';
include_once '../classes/Inventur.php';

$database = new Database();
$db = $database->getConnection();

$inventur = new Inventur($db);

$data = json_decode(file_get_contents("php://input"));

$inventur->Id = $data->Id;

if($inventur->finish()){
    http_response_code(200);
    echo json_encode(array("message" => "Die Inventur wurde beendet."));
}
else {
    http_response_code(503);
    echo json_encode(array("message" => "Inventur konnte nicht beendet werden."));
}
?>