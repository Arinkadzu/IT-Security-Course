<?php
if (!defined('WEB_ROOT')) {
exit;
}
$product = getProductDetail($pdId, $catId);
extract($product);
require_once 'include/pdview.php';
?>
