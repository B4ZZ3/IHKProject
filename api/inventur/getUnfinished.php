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
$stmt = $inventur->getUnfinished();
$num = $stmt->rowCount();
 
if($num>0){
    $result=array();
    $result["records"]=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $db_item = array(
            "id" => $Id,
            "datum" => $Datum,
            "mitarbeiter" => $Mitarbeiter,
            "inLager" => $InLager
        );
        array_push($result["records"], $db_item);
    }

    http_response_code(200);
    echo json_encode($result);
}
else {
    http_response_code(200);

    echo json_encode(
        array("message" => "Keine Inventur gefunden.")
    );
}
?>