<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once '../config/database.php';
include_once '../classes/Item.php';
 
$database = new Database();
$db = $database->getConnection();

$item = new Item($db);
$item->Inventarnummer = isset($_GET['Inventarnummer']) ? $_GET['Inventarnummer'] : die();
$item->getOne();
 
if($item->Name!=null){
    $item_arr = array(
        "inventarnummer" => $item->Inventarnummer,
        "name" => $item->Name,
        "bueroId" => $item->BueroId,
        "inLager" => $item->InLager
    );

    http_response_code(200);
    echo json_encode($item_arr);
}
else {
    http_response_code(404);
    echo json_encode(array("message" => "Das Geraet existiert nicht."));
}
?>