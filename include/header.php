<?php
if (!defined('WEB_ROOT')) {
	exit;
}
$pageTitle = 'Detailers Paradise';
if (isset($_GET['p']) && (int)$_GET['p'] > 0) {
	$pdId = (int)$_GET['p'];
	$sql = "SELECT pd_name
			FROM tbl_product
			WHERE pd_id = $pdId";
	
	$result    = dbQuery($sql);
	$row       = dbFetchAssoc($result);
	$pageTitle = $row['pd_name'];
	
} else if (isset($_GET['c']) && (int)$_GET['c'] > 0) {
	$catId = (int)$_GET['c'];
	$sql = "SELECT cat_name
	        FROM tbl_category
			WHERE cat_id = $catId";

    $result    = dbQuery($sql);
	$row       = dbFetchAssoc($result);
	$pageTitle = $row['cat_name'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title><?php echo $pageTitle; ?></title>
<meta http-equiv="content-type" content="application/xhtml+xml; charset=windows-1251" />
<link rel="stylesheet" type="text/css" media="screen" href="styles/style.css" />
</head>
<body>
<div id="wrap">
<div id="header">
<span id="slogan"> Высококачественная автокосметика</span>
<ul>
<li><a href="index.php"><span>Главная</span></a></li>
<li><a href="cart.php?action=view"><span>Корзина</span></a></li>
<li><a href="checkout.php?step=1"><span>Оформить заказ</span></a></li>		
</ul>
</div>
<div id="header-logo">
<div id="logo">Detailer's <span class="red">Paradise</span></div>
</div>