<?php
ini_set('display_errors', 'On');

error_reporting(E_ALL);


session_start();


$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = 'Separatum';
$dbName = 'detailersparadise';


$thisFile = str_replace('\\', '/', __FILE__);
$docRoot = $_SERVER['DOCUMENT_ROOT'];

$webRoot  = str_replace(array($docRoot, 'library/config.php'), '', $thisFile);
$srvRoot  = str_replace('library/config.php', '', $thisFile);

//define('WEB_ROOT', $webRoot);
define('WEB_ROOT', '/system/');  // Adjust this to match your project structure

define('SRV_ROOT', $srvRoot);


define('CATEGORY_IMAGE_DIR', 'images/category/');
define('PRODUCT_IMAGE_DIR',  'images/product/');



define('MAX_CATEGORY_IMAGE_WIDTH', 75);


define('LIMIT_PRODUCT_WIDTH',     true);


define('MAX_PRODUCT_IMAGE_WIDTH', 300);


define('THUMBNAIL_WIDTH',         75);

// Sanitize POST data
if (isset($_POST)) {
    foreach ($_POST as $key => $value) {
        // Apply trim and sanitization
        $_POST[$key] = trim(htmlspecialchars($value, ENT_QUOTES, 'UTF-8'));
    }
}

// Sanitize GET data
if (isset($_GET)) {
    foreach ($_GET as $key => $value) {
        // Apply trim and sanitization
        $_GET[$key] = trim(htmlspecialchars($value, ENT_QUOTES, 'UTF-8'));
    }
}



require_once 'database.php';
require_once 'common.php';

$shopConfig = getShopConfig();
?>