<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once '../config/database.php';
include_once '../classes/Item.php';

$database = new Database();
$db = $database->getConnection();

$item = new Item($db);

$data = json_decode(file_get_contents("php://input"));

$item->Inventarnummer = $data->Inventarnummer;
$item->Name = $data->Name;
$item->BueroId = $data->BueroId;
$item->InLager = $data->InLager;

if($item->update()){
    http_response_code(200);
    echo json_encode(array("message" => "Das Geraet wurde aktualisiert."));
}
else {
    http_response_code(503);
    echo json_encode(array("message" => "Nicht möglich das Geraet zu aktualisieren."));
}
?>