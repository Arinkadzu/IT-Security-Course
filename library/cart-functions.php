<?php
require_once 'config.php';

function addToCart()
{
	if (isset($_GET['p']) && (int)$_GET['p'] > 0) {
		$productId = (int)$_GET['p'];
	} else {
		header('Location: index.php');
	}

	$sql = "SELECT pd_id, pd_qty
	        FROM tbl_product
			WHERE pd_id = $productId";
	$result = dbQuery($sql);
	
	if (dbNumRows($result) != 1) {

		header('Location: cart.php');
	} else {

		$row = dbFetchAssoc($result);
		$currentStock = $row['pd_qty'];

		if ($currentStock == 0) {

			setError('The product you requested is no longer in stock');
			header('Location: cart.php');
			exit;
		}

	}		

	$sid = session_id();

	$sql = "SELECT pd_id
	        FROM tbl_cart
			WHERE pd_id = $productId AND ct_session_id = '$sid'";
	$result = dbQuery($sql);
	
	if (dbNumRows($result) == 0) {
		$sql = "INSERT INTO tbl_cart (pd_id, ct_qty, ct_session_id, ct_date)
				VALUES ($productId, 1, '$sid', NOW())";
		$result = dbQuery($sql);
	} else {

		$sql = "UPDATE tbl_cart 
		        SET ct_qty = ct_qty + 1
				WHERE ct_session_id = '$sid' AND pd_id = $productId";		
				
		$result = dbQuery($sql);		
	}
	deleteAbandonedCart();
	
	header('Location: ' . $_SESSION['shop_return_url']);				
}

/*
	Get all item in current session
	from shopping cart table
*/
function getCartContent()
{
	$cartContent = array();

	$sid = session_id();
	$sql = "SELECT ct_id, ct.pd_id, ct_qty, pd_name, pd_price, pd_thumbnail, pd.cat_id
			FROM tbl_cart ct, tbl_product pd, tbl_category cat
			WHERE ct_session_id = '$sid' AND ct.pd_id = pd.pd_id AND cat.cat_id = pd.cat_id";
	
	$result = dbQuery($sql);
	
	while ($row = dbFetchAssoc($result)) {
		if ($row['pd_thumbnail']) {
			$row['pd_thumbnail'] = 'images/product/' . $row['pd_thumbnail'];
		} else {
			$row['pd_thumbnail'] = 'images/no-image-small.png';
		}
		$cartContent[] = $row;
	}
	
	return $cartContent;
}

function deleteFromCart($cartId = 0)
{
	if (!$cartId && isset($_GET['cid']) && (int)$_GET['cid'] > 0) {
		$cartId = (int)$_GET['cid'];
	}

	if ($cartId) {	
		$sql  = "DELETE FROM tbl_cart
				 WHERE ct_id = $cartId";

		$result = dbQuery($sql);
	}
	
	header('Location: cart.php');	
}

function updateCart()
{
	$cartId     = $_POST['hidCartId'];
	$productId  = $_POST['hidProductId'];
	$itemQty    = $_POST['txtQty'];
	$numItem    = count($itemQty);
	$numDeleted = 0;
	$notice     = '';
	
	for ($i = 0; $i < $numItem; $i++) {
		$newQty = (int)$itemQty[$i];
		if ($newQty < 1) {

			deleteFromCart($cartId[$i]);	
			$numDeleted += 1;
		} else {

			$sql = "SELECT pd_name, pd_qty
			        FROM tbl_product 
					WHERE pd_id = {$productId[$i]}";
			$result = dbQuery($sql);
			$row    = dbFetchAssoc($result);
			
			if ($newQty > $row['pd_qty']) {
				// we only have this much in stock
				$newQty = $row['pd_qty'];

				if ($row['pd_qty'] > 0) {
					setError('The quantity you have requested is more than we currently have in stock. The number available is indicated in the &quot;Quantity&quot; box. ');
				} else {

					setError('Sorry, but the product you want (' . $row['pd_name'] . ') is no longer in stock');


					deleteFromCart($cartId[$i]);	
					$numDeleted += 1;					
				}
			} 
							

			$sql = "UPDATE tbl_cart
					SET ct_qty = $newQty
					WHERE ct_id = {$cartId[$i]}";
				
			dbQuery($sql);
		}
	}
	
	if ($numDeleted == $numItem) {

		header("Location: $returnUrl" . $_SESSION['shop_return_url']);
	} else {
		header('Location: cart.php');	
	}
	
	exit;
}

function isCartEmpty()
{
	$isEmpty = false;
	
	$sid = session_id();
	$sql = "SELECT ct_id
			FROM tbl_cart ct
			WHERE ct_session_id = '$sid'";
	
	$result = dbQuery($sql);
	
	if (dbNumRows($result) == 0) {
		$isEmpty = true;
	}	
	
	return $isEmpty;
}

function deleteAbandonedCart()
{
	$yesterday = date('Y-m-d H:i:s', mktime(0,0,0, date('m'), date('d') - 1, date('Y')));
	$sql = "DELETE FROM tbl_cart
	        WHERE ct_date < '$yesterday'";
	dbQuery($sql);		
}

?>