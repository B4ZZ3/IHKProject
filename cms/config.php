<?php
ini_set("display_errors", true); //just for debugging, on live server false
date_default_timezone_set("Europe/Berlin");
define("DB_DSN", "mysql:host=localhost;dbname=inventareoa");
define("DB_USERNAME", "eoaInventar");
define("DB_PASSWORD", "Test4711");
define("CLASS_PATH", "classes");
define("TEMPLATE_PATH", "templates");
require(CLASS_PATH."/Item.php");
require(CLASS_PATH."/Category.php");
require(CLASS_PATH."/Producer.php");
require(CLASS_PATH."/Office.php");

function handleException($exception) {
    echo "Tut mir leid, es ist ein Problem aufgetreten. Bitte versuchen Sie es später noch einmal.";
    error_log($exception->getMessage());
}

function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}

set_exception_handler('handleException');
?>