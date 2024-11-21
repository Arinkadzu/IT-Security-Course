<?php
if (!defined('WEB_ROOT')) {
	exit;
}


$categories = fetchCategories();


$categories = formatCategories($categories, $catId);
?>

        <div id="sidebar" >

			<h1>Категории</h1>
			<div class="left-box">
				<ul class="sidemenu">
				
				
				<?php
foreach ($categories as $category) {
	extract($category);

	
	$level = ($cat_parent_id == 0) ? 1 : 2;
    $url   = $_SERVER['PHP_SELF'] . "?c=$cat_id";

	if ($level == 2) {
		$cat_name = '&nbsp; &nbsp; &raquo;&nbsp;' . $cat_name;
	}
	

	$listId = '';
	if ($cat_id == $catId) {
		$listId = ' id="current"';
	}
?>
<li<?php echo $listId; ?>><a href="<?php echo $url; ?>"><?php echo $cat_name; ?></a></li>
<?php
}
?>
				

				</ul>
			</div>
			<h1>Содержание корзины</h1>
						<div class="left-box">
				<ul class="sidemenu">
				<?php require_once 'include/miniCart.php'; ?>

				</ul>
			</div>



		</div>
