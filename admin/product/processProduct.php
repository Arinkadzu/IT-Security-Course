<?php
require_once '../../library/config.php';
require_once '../library/functions.php';

checkUser();

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {

	case 'addProduct':
		addProduct();
		break;

	case 'modifyProduct':
		modifyProduct();
		break;

	case 'deleteProduct':
		deleteProduct();
		break;

	case 'deleteImage':
		deleteImage();
		break;


	default:

		header('Location: index.php');
}


function addProduct()
{
	$catId       = $_POST['cboCategory'];
	$name        = $_POST['txtName'];
	$description = $_POST['mtxDescription'];
	$price       = str_replace(',', '', (float)$_POST['txtPrice']);
	$qty         = (int)$_POST['txtQty'];

	$images = uploadProductImage('fleImage', SRV_ROOT . 'images/product/');

	$mainImage = $images['image'];
	$thumbnail = $images['thumbnail'];

	$sql   = "INSERT INTO tbl_product (cat_id, pd_name, pd_description, pd_price, pd_qty, pd_image, pd_thumbnail, pd_date)
	          VALUES ('$catId', '$name', '$description', $price, $qty, '$mainImage', '$thumbnail', NOW())";

	$result = dbQuery($sql);

	header("Location: index.php?catId=$catId");
}

function uploadProductImage($inputName, $uploadDir)
{
	$image     = $_FILES[$inputName];
	$imagePath = '';
	$thumbnailPath = '';

	// if a file is given
	if (trim($image['tmp_name']) != '') {
		$ext = substr(strrchr($image['name'], "."), 1);

		$imagePath = md5(rand() * time()) . ".$ext";

		list($width, $height, $type, $attr) = getimagesize($image['tmp_name']);

		if (LIMIT_PRODUCT_WIDTH && $width > MAX_PRODUCT_IMAGE_WIDTH) {
			$result    = createThumbnail($image['tmp_name'], $uploadDir . $imagePath, MAX_PRODUCT_IMAGE_WIDTH);
			$imagePath = $result;
		} else {
			$result = move_uploaded_file($image['tmp_name'], $uploadDir . $imagePath);
		}

		if ($result) {

			$thumbnailPath =  md5(rand() * time()) . ".$ext";
			$result = createThumbnail($uploadDir . $imagePath, $uploadDir . $thumbnailPath, THUMBNAIL_WIDTH);


			if (!$result) {
				unlink($uploadDir . $imagePath);
				$imagePath = $thumbnailPath = '';
			} else {
				$thumbnailPath = $result;
			}
		} else {

			$imagePath = $thumbnailPath = '';
		}
	}


	return array('image' => $imagePath, 'thumbnail' => $thumbnailPath);
}

function modifyProduct()
{
    $productId   = (int)$_GET['productId'];
    $catId       = (int)$_POST['cboCategory'];
    $name        = mysqli_real_escape_string($GLOBALS['dbConn'], $_POST['txtName']);
    $description = mysqli_real_escape_string($GLOBALS['dbConn'], $_POST['mtxDescription']);
    $price       = str_replace(',', '', (double)$_POST['txtPrice']);
    $qty         = (int)$_POST['txtQty'];

    $images = uploadProductImage('fleImage', SRV_ROOT . 'images/product/');
    $mainImage = $images['image'];
    $thumbnail = $images['thumbnail'];

    // Start building the query
    $sql = "UPDATE tbl_product 
            SET cat_id = $catId, 
                pd_name = '$name', 
                pd_description = '$description', 
                pd_price = $price, 
                pd_qty = $qty";

    // Add image fields only if a new image is uploaded
    if ($mainImage != '') {
        _deleteImage($productId); // Delete old images
        $sql .= ", pd_image = '$mainImage', pd_thumbnail = '$thumbnail'";
    }

    // Add the WHERE clause
    $sql .= " WHERE pd_id = $productId";

    // Debugging: Log the query for testing
    error_log("SQL Query: $sql");

    // Execute the query
    dbQuery($sql);

    // Redirect to the product list
    header('Location: index.php');
}

function deleteProduct()
{
	if (isset($_GET['productId']) && (int)$_GET['productId'] > 0) {
		$productId = (int)$_GET['productId'];
	} else {
		header('Location: index.php');
	}

	$sql = "DELETE FROM tbl_order_item
	        WHERE pd_id = $productId";
	dbQuery($sql);

	$sql = "DELETE FROM tbl_cart
	        WHERE pd_id = $productId";
	dbQuery($sql);


	$sql = "SELECT pd_image, pd_thumbnail
	        FROM tbl_product
			WHERE pd_id = $productId";

	$result = dbQuery($sql);
	$row    = dbFetchAssoc($result);


	if ($row['pd_image']) {
		unlink(SRV_ROOT . 'images/product/' . $row['pd_image']);
		unlink(SRV_ROOT . 'images/product/' . $row['pd_thumbnail']);
	}

	$sql = "DELETE FROM tbl_product 
	        WHERE pd_id = $productId";
	dbQuery($sql);

	header('Location: index.php?catId=' . $_GET['catId']);
}

function deleteImage()
{
	if (isset($_GET['productId']) && (int)$_GET['productId'] > 0) {
		$productId = (int)$_GET['productId'];
	} else {
		header('Location: index.php');
	}

	$deleted = _deleteImage($productId);


	$sql = "UPDATE tbl_product
			SET pd_image = '', pd_thumbnail = ''
			WHERE pd_id = $productId";
	dbQuery($sql);

	header("Location: index.php?view=modify&productId=$productId");
}

function _deleteImage($productId)
{

	$deleted = false;

	$sql = "SELECT pd_image, pd_thumbnail 
	        FROM tbl_product
			WHERE pd_id = $productId";
	$result = dbQuery($sql) or die('Cannot delete product image. ' . mysql_error());

	if (dbNumRows($result)) {
		$row = dbFetchAssoc($result);
		extract($row);

		if ($pd_image && $pd_thumbnail) {

			$deleted = @unlink(SRV_ROOT . "images/product/$pd_image");
			$deleted = @unlink(SRV_ROOT . "images/product/$pd_thumbnail");
		}
	}

	return $deleted;
}
