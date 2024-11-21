<?php
if (!defined('WEB_ROOT')) {
	exit;
}
$categoryList    = getCategoryList();
$categoriesPerRow = 3;
$numCategory     = count($categoryList);
$columnWidth    = (int)(100 / $categoriesPerRow);
require_once 'include/catlistview.php';
?>