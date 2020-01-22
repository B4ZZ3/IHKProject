<?php
require("config.php");
session_start();
$action = isset( $_GET['action'] ) ? $_GET['action'] : "";
$mitarbeiter = isset( $_SESSION['Mitarbeiter'] ) ? $_SESSION['Mitarbeiter'] : "";

if ( $action != "login" && $action != "finish" && !$mitarbeiter ) {
  login();
  exit;
}

switch ( $action ) {
  case 'login':
    login();
    break;
  case 'finish':
    finishInventur();
    break;
  case 'endInventur':
    endInventur();
    break;
  case 'scanBuero':
    scan("office");
    break;
  case 'scanItem':
    scan("item");
    break;
  case 'postQRCode':
    postQRCode();
    break;
  default:
    scan("office");
}

function login() {
  session_unset();
  $results['inventur'] = Inventur::getUnfinished();
  if(isset($results['inventur']))$_SESSION['Mitarbeiter'] = $results['inventur']->Mitarbeiter;
  if(isset($results['inventur']))$_SESSION['inventurId'] = $results['inventur']->Id;

  if ( isset( $_POST['login'] ) ) {
      $_SESSION['Mitarbeiter'] = $_POST['mitarbeiterName'];
      startInventur();
      header( "Location: index.php" );
  } else {
    require( TEMPLATE_PATH . "/start.php" );
  }
}

function startInventur() {
  $inventur = new Inventur;
  $inventur->Mitarbeiter = $_SESSION['Mitarbeiter'];
  $inventur->start();
}

function finishInventur() {
  $result['inventur'] = Inventur::getUnfinished();
  $inventur = new Inventur;
  $inventur->Id = $result['inventur']->Id;
  $inventur->finish();
  session_unset();
  header( "Location: index.php" );
}

function postQRCode() { 
  if ( isset( $_POST['qrCodeBuero'] ) ) {
      unset($_SESSION['BueroId']);
      $_SESSION['BueroId'] = $_POST['qrValue'];
      header( "Location: index.php?action=scanItem" );
  } 
  else if ( isset( $_POST['qrCodeItem'] ) ) {
      unset($_SESSION['Inventarnummer']);
      $_SESSION['Inventarnummer'] = $_POST['qrValue'];
      insertGeraetInventur();
      header( "Location: index.php?action=scanItem" );
  }
  else {
    require( TEMPLATE_PATH . "/scan.php" );
  }
}

function insertGeraetInventur() {
  $results['inventur'] = Inventur::getUnfinished();
  $inventur = new Inventur;
  $inventur->Id = $results['inventur']->Id;
  $splitBuero = explode("=", $_SESSION['BueroId']);
  $inventur->BueroId = (int)$splitBuero[1];
  $splitInventarnummer = explode("=", $_SESSION['Inventarnummer']);
  $inventur->GeraeteInv = (int)$splitInventarnummer[1];
  $inventur->insertGeraete();
}

function endInventur() {   
  $data = Item::getRemainingGeraete();
  if($data["results"] != null)
  {
    console_log($data);
    $results = array();
    $results['items'] = $data['results'];
    $results['totalRows'] = $data['totalRows'];
    require( TEMPLATE_PATH . "/showGeraete.php" );
  }
  else {
    finishInventur();
  }
}

function scan($value) {
  $results = array();
  if($value === "office") {
    $results['value'] = "office";
    $results['scanHeadline'] = "Ein Büro einscannen";
    $results['secondaryBtnText'] = "Inventur beenden";
    $results['errorMessage'] = "Sie haben kein Büro eingescannt. Bitte versuchen Sie es nochmal!";
  }
  elseif($value === "item") {
    $results['value'] = "item";
    $results['scanHeadline'] = "Ein Gerät einscannen";
    $results['secondaryBtnText'] = "Neues Büro einscannen";
    $results['errorMessage'] = "Sie haben kein Gerät eingescannt. Bitte versuchen Sie es nochmal!";
  }
  require( TEMPLATE_PATH . "/scan.php" );
}

?>