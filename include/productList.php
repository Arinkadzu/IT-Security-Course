<?php
if (!defined('WEB_ROOT')) {
	exit;
}
$productsPerRow = 3;
$productsPerPage = 12;
$children = array_merge(array($catId), getChildCategories(NULL, $catId));
$children = ' (' . implode(', ', $children) . ')';
$sql = "SELECT pd_id, pd_name, pd_price, pd_thumbnail, pd_qty, c.cat_id
		FROM tbl_product pd, tbl_category c
		WHERE pd.cat_id = c.cat_id AND pd.cat_id IN $children 
		ORDER BY pd_name";
$result     = dbQuery(getPagingQuery($sql, $productsPerPage));
$pagingLink = getPagingLink($sql, $productsPerPage, "c=$catId");
$numProduct = dbNumRows($result);
$columnWidth = (int)(100 / $productsPerRow);
require_once 'include/pdlistview.php';
?>