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
 
if(!empty($data->geraeteInv) && !empty($data->inventurId) && !empty($data->bueroId)) {
    $inventur->GeraeteInv = $data->geraeteInv;
    $inventur->Id = $data->inventurId;
    $inventur->BueroId = $data->bueroId;
 
    if($inventur->insertGeraete()){
        http_response_code(201);
        echo json_encode(array("message" => "Gerät wurde erfasst."));
    }
    else {
        http_response_code(503);
        echo json_encode(array("message" => "Gerät wurde bereits erfasst."));
    }
}
else {
    http_response_code(400);
    echo json_encode(array("message" => "Nicht möglich das Gerät zu erfassen. Daten sind unvollständig."));
}
?>