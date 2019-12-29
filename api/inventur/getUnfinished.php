<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once '../config/database.php';
include_once '../classes/Inventur.php';
 
$database = new Database();
$db = $database->getConnection();

$inventur = new Inventur($db);
$inventur->Id = isset($_GET['Id']) ? $_GET['Id'] : die();
$inventur->getUnfinished();
 
if($inventur->Id!=null){
    $inventur_arr = array(
        "id" => $inventur->Id,
        "datum" => $inventur->Datum,
        "mitarbeiter" => $inventur->Mitarbeiter,    
        "finished" => $inventur->Finished
    );

    http_response_code(200);
    echo json_encode($inventur_arr);
}
else {
    http_response_code(404);
    echo json_encode(array("message" => "Die Inventur existiert nicht."));
}
?>