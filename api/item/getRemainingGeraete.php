<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../classes/Item.php';

$database = new Database();
$db = $database->getConnection();

$item = new Item($db);

$stmt = $item->getRemainingGeraete();
$num = $stmt->rowCount();
 
if($num>0){
    $result=array();
    $result["records"]=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $db_item = array(
            "name" => $Name,
            "bueroName" => $BueroName
        );
        array_push($result["records"], $db_item);
    }

    http_response_code(200);
    echo json_encode($result);
}
else {
    http_response_code(404);

    echo json_encode(
        array("message" => "Alle Geraete wurden inventarisiert.")
    );
}