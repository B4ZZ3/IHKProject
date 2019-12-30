<?php
require("config.php");
require("lib/qrlib.php");
session_start();
$action = isset( $_GET['action'] ) ? $_GET['action'] : "";
$username = isset( $_SESSION['username'] ) ? $_SESSION['username'] : "";

if ( $action != "login" && $action != "logout" && !$username ) {
  login();
  exit;
}

switch ( $action ) {
  case 'login':
    login();
    break;
  case 'logout':
    logout();
    break;
  case 'newItem':
    newItem();
    break;
  case 'editItem':
    editItem();
    break;
  case 'deleteItem':
    deleteItem();
    break;
  case 'listCategories':
    listProperties("category");
    break;
  case 'newCategory':
    newProperty("category");
    break;
  case 'editCategory':
    editProperty("category");
    break;
  case 'deleteCategory':
    deleteProperty("category");
    break;
  case 'viewAllByCategory':
    viewList("category");
    break;
  case 'listOffices':
    listProperties("office");
    break;
  case 'newOffice':
    newProperty("office");
    break;
  case 'editOffice':
    editProperty("office");
    break;
  case 'deleteOffice':
    deleteProperty("office");
    break;
  case 'viewAllByOffice':
    viewList("office");
    break;
  case 'listProducer':
    listProperties("producer");
    break;
  case 'newProducer':
    newProperty("producer");
    break;
  case 'editProducer':
    editProperty("producer");
    break;
  case 'deleteProducer':
    deleteProperty("producer");
    break;
  case 'viewAllByProducer':
    viewList("producer");
    break;
  case 'viewAllInStock':
    viewList("inStock");
    break;
  default:
    listItems();
}

//Login/Logout-Section
function login() {

    $results = array();
    $results['pageTitle'] = "Admin Login | eoa Inventar";

    if ( isset( $_POST['login'] ) ) {
      $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
      $st = $conn->prepare ( "SELECT Username, Password FROM users WHERE Username = :Username LIMIT 1" );
      $st->bindValue( ":Username", $_POST['username'], PDO::PARAM_STR );
      $st->execute();
      $list = array();
      while ( $row = $st->fetch() ) {
        $list['user'] = $row;
      }
      $conn = null;
      
      if ( $_POST['username'] == $list['user']['Username'] && password_verify($_POST['password'],$list['user']['Password']) ) {
        $_SESSION['username'] = $list['user']['Username'];
        header( "Location: index.php" );
      } 
      else {
        $results['errorMessage'] = "Falscher Benutzername oder falsches Passwort. Bitte versuchen Sie es erneut.";
        require( TEMPLATE_PATH . "/admin/loginForm.php" );
      }
    } 
    else {
      require( TEMPLATE_PATH . "/admin/loginForm.php" );
    }
}

function logout() {
  unset( $_SESSION['username'] );
  header( "Location: index.php" );
}

//Item-Section
function newItem() {
  $results = array();
  $results['pageTitle'] = "Neues Gerät";
  $results['formAction'] = "newItem";

  if ( isset( $_POST['saveChanges'] ) ) {
    $item = new Item;
    $item->InLager = (int)$_POST['InLager'];
    $item->storeFormValues( $_POST );
    $item->insert();
    $item->generateQRCode();
    header( "Location: index.php?status=changesSaved" );
  } 
  elseif ( isset( $_POST['cancel'] ) ) {
    header( "Location: index.php" );
  } 
  else {
    $results['item'] = new Item;
    $data = Category::getList();
    $results['categories'] = $data['results'];
    $data = Producer::getList();
    $results['producer'] = $data['results'];
    $data = Office::getList();
    $results['office'] = $data['results'];
    require( TEMPLATE_PATH . "/admin/editItem.php" );
  }
}

function editItem() {
  $results = array();
  $results['pageTitle'] = "Gerät bearbeiten";
  $results['formAction'] = "editItem";

  if ( isset( $_POST['saveChanges'] ) ) {
    if ( !$item = Item::getById( (int)$_POST['Id'] ) ) {
      header( "Location: index.php?error=itemNotFound" );
      return;
    }

    $item->InLager = (int)$_POST['InLager'];
    $item->storeFormValues($_POST);
    $item->update();
    $item->generateQRCode();
    header( "Location: index.php?status=changesSaved" );
  } 
  elseif ( isset( $_POST['cancel'] ) ) {
    header( "Location: index.php" );
  } 
  else {
    $results['item'] = Item::getById( (int)$_GET['itemId'] );
    $data = Category::getList();
    $results['categories'] = $data['results'];
    $data = Producer::getList();
    $results['producer'] = $data['results'];
    $data = Office::getList();
    $results['office'] = $data['results'];
    require( TEMPLATE_PATH . "/admin/editItem.php" );
  }
}

function deleteItem() {
  if ( !$item = Item::getById( (int)$_GET['itemId'] ) ) {
    header( "Location: index.php?error=itemNotFound" );
    return;
  }
  $item->delete();
  header( "Location: index.php?status=itemDeleted" );
}

function listItems() {
  $results = array();
  $data = Item::getList();
  $results['items'] = $data['results'];
  $results['totalRows'] = $data['totalRows'];
  $results['pageTitle'] = "eoa Inventar";

  if ( isset( $_GET['error'] ) ) {
    if ( $_GET['error'] == "itemNotFound" ) $results['errorMessage'] = "Fehler: Das Gerät wurde nicht gefunden.";
  }

  if ( isset( $_GET['status'] ) ) {
    if ( $_GET['status'] == "changesSaved" ) $results['statusMessage'] = "Deine Änderungen wurden gespeichert.";
    if ( $_GET['status'] == "ItemDeleted" ) $results['statusMessage'] = "Das Gerät wurde erfolgreich gelöscht.";
  }

  require( TEMPLATE_PATH . "/admin/overview.php" );
}

//Property-Section
function newProperty($property) {
  $results = array();
  if($property === "category") {
    $results['pageTitle'] = "Neue Geräte-Kategorie";
    $results['formAction'] = "newCategory";
    $results['nameId'] = "categoryId";
    $results['placeholder'] = "der Kategorie";

    if ( isset( $_POST['saveChanges'] ) ) {
      $category = new Category;
      $category->storeFormValues( $_POST );
      $category->insert();
      header( "Location: index.php?action=listCategories&status=changesSaved" );
    } 
    elseif ( isset( $_POST['cancel'] ) ) {
      header( "Location: index.php?action=listCategories" );
    } 
    else {
      $results['property'] = new Category;
      require( TEMPLATE_PATH . "/admin/editProperty.php" );
    }
  }
  elseif($property === "office") {
    $results['pageTitle'] = "Neues Büro";
    $results['formAction'] = "newOffice";
    $results['nameId'] = "officeId";
    $results['placeholder'] = "des Büros";

    if ( isset( $_POST['saveChanges'] ) ) {
      $office = new Office;
      $office->storeFormValues( $_POST );
      $office->generateQRCode($office->insert());
      header( "Location: index.php?action=listOffices&status=changesSaved" );
    } 
    elseif ( isset( $_POST['cancel'] ) ) {
      header( "Location: index.php?action=listOffices" );
    } 
    else {
      $results['property'] = new Office;
      require( TEMPLATE_PATH . "/admin/editProperty.php" );
    }
  }
  elseif($property === "producer") {
    $results['pageTitle'] = "Neuer Hersteller";
    $results['formAction'] = "newProducer";
    $results['nameId'] = "producerId";
    $results['placeholder'] = "des Herstellers";

    if ( isset( $_POST['saveChanges'] ) ) {
      $producer = new Producer;
      $producer->storeFormValues( $_POST );
      $producer->insert();
      header( "Location: index.php?action=listProducer&status=changesSaved" );
    } 
    elseif ( isset( $_POST['cancel'] ) ) {
      header( "Location: index.php?action=listProducer" );
    } 
    else {
      $results['property'] = new Producer;
      require( TEMPLATE_PATH . "/admin/editProperty.php" );
    }
  }
}

function editProperty($property) {
  $results = array();
  if($property === "category") {
    $results['pageTitle'] = "Kategorie bearbeiten";
    $results['formAction'] = "editCategory";
    $results['nameId'] = "categoryId";
    $results['placeholder'] = "der Kategorie";

    if ( isset( $_POST['saveChanges'] ) ) {
      if ( !$category = Category::getById( (int)$_POST['categoryId'] ) ) {
        header( "Location: index.php?action=listCategories&error=categoryNotFound" );
        return;
      }
      $category->storeFormValues( $_POST );
      $category->update();
      header( "Location: index.php?action=listCategories&status=changesSaved" );
    } 
    elseif ( isset( $_POST['cancel'] ) ) {
      header( "Location: index.php?action=listCategories" );
    } 
    else {
      $results['property'] = Category::getById( (int)$_GET['categoryId'] );
      require( TEMPLATE_PATH . "/admin/editProperty.php" );
    }
  }
  elseif($property === "office") {
    $results['pageTitle'] = "Büro bearbeiten";
    $results['formAction'] = "editOffice";
    $results['nameId'] = "officeId";
    $results['placeholder'] = "des Büros";

    if ( isset( $_POST['saveChanges'] ) ) {
      if ( !$office = Office::getById( (int)$_POST['officeId'] ) ) {
        header( "Location: index.php?action=listOffices&error=officeNotFound" );
        return;
      }

      $office->storeFormValues( $_POST );
      $office->update();
      $office->generateQRCode();
      header( "Location: index.php?action=listOffices&status=changesSaved" );
    } 
    elseif ( isset( $_POST['cancel'] ) ) {
      header( "Location: index.php?action=listOffices" );
    } 
    else {
      $results['property'] = Office::getById( (int)$_GET['officeId'] );
      require( TEMPLATE_PATH . "/admin/editProperty.php" );
    }
  }
  elseif($property === "prodcuer") {
    $results['pageTitle'] = "Hersteller bearbeiten";
    $results['formAction'] = "editProducer";
    $results['nameId'] = "producerId";
    $results['placeholder'] = "des Herstellers";

    if ( isset( $_POST['saveChanges'] ) ) {
      if ( !$producer = Producer::getById( (int)$_POST['producerId'] ) ) {
        header( "Location: index.php?action=listProducer&error=producerNotFound" );
        return;
      }

      $producer->storeFormValues( $_POST );
      $producer->update();
      header( "Location: index.php?action=listProducer&status=changesSaved" );
    } 
    elseif ( isset( $_POST['cancel'] ) ) {
      header( "Location: index.php?action=listProducer" );
    } 
    else {
      $results['property'] = Producer::getById( (int)$_GET['producerId'] );
      require( TEMPLATE_PATH . "/admin/editProperty.php" );
    }
  }
}

function deleteProperty($property) {
  if($property === "category") {
    if ( !$category = Category::getById( (int)$_GET['categoryId'] ) ) {
      header( "Location: index.php?action=listCategories&error=categoryNotFound" );
      return;
    }
    $items = Item::getList($category->Id );

    if ( $items['totalRows'] > 0 ) {
      header( "Location: index.php?action=listCategories&error=categoryContainsItems" );
      return;
    }
    $category->delete();
    header( "Location: index.php?action=listCategories&status=categoryDeleted" );
  }
  elseif($property === "office") {
    if ( !$office = Office::getById( (int)$_GET['officeId'] ) ) {
      header( "Location: index.php?action=listOffices&error=officeNotFound" );
      return;
    }
    $items = Item::getList($office->Id );

    if ( $items['totalRows'] > 0 ) {
      header( "Location: index.php?action=listOffices&error=officeContainsItems" );
      return;
    }
    $office->delete();
    header( "Location: index.php?action=listOffices&status=officeDeleted" );
  }
  elseif($property === "producer") {
    if ( !$producer = Producer::getById( (int)$_GET['producerId'] ) ) {
      header( "Location: index.php?action=listProducers&error=producerNotFound" );
      return;
    }
    $items = Item::getList($producer->Id );

    if ( $items['totalRows'] > 0 ) {
      header( "Location: index.php?action=listProducers&error=producerContainsItems" );
      return;
    }
    $producer->delete();
    header( "Location: index.php?action=listProducers&status=producerDeleted" );
  }
}

function listProperties($property) {
  $results = array();
  if($property === "category") {
    $data = Category::getList();
    $results['properties'] = $data['results'];
    $results['totalRows'] = $data['totalRows'];
    $results['pageTitle'] = "Alle Geräte Kategorien";
    $results['NameProperty'] = "Category";
    $results['nameProperty'] = "category";

    if ( isset( $_GET['error'] ) ) {
      if ( $_GET['error'] == "categoryNotFound" ) $results['errorMessage'] = "Fehler: Die Kategorie wurde nicht gefunden.";
      if ( $_GET['error'] == "categoryContainsItems" ) $results['errorMessage'] = "Fehler: Kategorie enthält Geräte. Löschen Sie die Geräte, oder ordnen Sie sie einer anderen Kategorie zu, bevor Sie diese Kategorie löschen.";
    }

    if ( isset( $_GET['status'] ) ) {
      if ( $_GET['status'] == "changesSaved" ) $results['statusMessage'] = "Deine Änderungen wurden gespeichert.";
      if ( $_GET['status'] == "categoryDeleted" ) $results['statusMessage'] = "Die Kategorie wurde erfolgreich gelöscht.";
    }
  }
  elseif($property === "office") {
    $data = Office::getList();
    $results['properties'] = $data['results'];
    $results['totalRows'] = $data['totalRows'];
    $results['pageTitle'] = "Alle Büros";
    $results['NameProperty'] = "Office";
    $results['nameProperty'] = "office";

    if ( isset( $_GET['error'] ) ) {
      if ( $_GET['error'] == "officeNotFound" ) $results['errorMessage'] = "Fehler: Das Büro wurde nicht gefunden.";
      if ( $_GET['error'] == "officeContainsItems" ) $results['errorMessage'] = "Fehler: Büro enthält Geräte. Löschen Sie die Geräte, oder ordnen Sie sie einem anderen Büro zu, bevor Sie dieses Büro löschen.";
    }

    if ( isset( $_GET['status'] ) ) {
      if ( $_GET['status'] == "changesSaved" ) $results['statusMessage'] = "Deine Änderungen wurden gespeichert.";
      if ( $_GET['status'] == "officeDeleted" ) $results['statusMessage'] = "Das Büro wurde erfolgreich gelöscht.";
    }
  }
  elseif($property === "producer") {
    $data = Producer::getList();
    $results['properties'] = $data['results'];
    $results['totalRows'] = $data['totalRows'];
    $results['pageTitle'] = "Alle Hersteller";
    $results['NameProperty'] = "Producer";
    $results['nameProperty'] = "producer";

    if ( isset( $_GET['error'] ) ) {
      if ( $_GET['error'] == "producerNotFound" ) $results['errorMessage'] = "Fehler: Der Hersteller wurde nicht gefunden.";
      if ( $_GET['error'] == "producerContainsItems" ) $results['errorMessage'] = "Fehler: Hersteller enthält Geräte. Löschen Sie die Geräte, oder ordnen Sie sie einem anderen Hersteller zu, bevor Sie diesen Hersteller löschen.";
    }

    if ( isset( $_GET['status'] ) ) {
      if ( $_GET['status'] == "changesSaved" ) $results['statusMessage'] = "Deine Änderungen wurden gespeichert.";
      if ( $_GET['status'] == "producerDeleted" ) $results['statusMessage'] = "Der Hersteller wurde erfolgreich gelöscht.";
    }
  }
  require( TEMPLATE_PATH . "/admin/listProperties.php" );
}

function viewList($property) {
  $results = array();
  if($property === "category") {
    $categoryId = ( isset( $_GET['categoryId'] ) && $_GET['categoryId'] ) ? (int)$_GET['categoryId'] : null; 
    $results['category'] = Category::getById( $categoryId );
    $data = Item::getList($results['category'] ? $results['category']->Id : null, null, null, null);
    $results['items'] = $data['results'];
    $results['totalRows'] = $data['totalRows'];
    $results['pageHeading'] = $results['category'] ?  $results['category']->Name : "Alle Geräte";
    $results['pageTitle'] ="Alle Geräte der Kategorie: ". $results['pageHeading'];
  }
  elseif($property === "office") {
    $officeId = ( isset( $_GET['officeId'] ) && $_GET['officeId'] ) ? (int)$_GET['officeId'] : null; 
    $results['office'] = Office::getById( $officeId );
    $data = Item::getList(null, null, $results['office'] ? $results['office']->Id : null, null);
    $results['items'] = $data['results'];
    $results['totalRows'] = $data['totalRows'];
    $results['pageHeading'] = $results['office'] ?  $results['office']->Name : "Alle Geräte";
    $results['pageTitle'] ="Alle Geräte in dem Büro: ". $results['pageHeading'];
  }
  elseif($property === "producer") {
    $producerId = ( isset( $_GET['producerId'] ) && $_GET['producerId'] ) ? (int)$_GET['producerId'] : null; 
    $results['producer'] = Producer::getById( $producerId );
    $data = Item::getList(null, $results['producer'] ? $results['producer']->Id : null, null, null);
    $results['items'] = $data['results'];
    $results['totalRows'] = $data['totalRows'];
    $results['pageHeading'] = $results['producer'] ?  $results['producer']->Name : "Alle Geräte";
    $results['pageTitle'] ="Alle Geräte des Herstellers: ". $results['pageHeading'];
  }
  elseif($property === "inStock") {
    // $producerId = ( isset( $_GET['producerId'] ) && $_GET['producerId'] ) ? (int)$_GET['producerId'] : null; 
    // $results['producer'] = Producer::getById( $producerId );
    $data = Item::getList(null, null, null, 1);
    $results['items'] = $data['results'];
    $results['totalRows'] = $data['totalRows'];
    $results['pageTitle'] = "Alle Geräte im Lager";
  }
  require( TEMPLATE_PATH . "/admin/listAll.php" );
}
?>