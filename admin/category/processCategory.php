<?php
require_once '../../library/config.php';
require_once '../library/functions.php';

checkUser();

$action = isset($_GET['action']) ? $_GET['action'] : '';
switch ($action) {
	
    case 'add' :
        addCategory();
        break;
      
    case 'modify' :
        modifyCategory();
        break;
        
    case 'delete' :
        deleteCategory();
        break;
    
    case 'deleteImage' :
        deleteImage();
        break;
    
	   
    default :

        header('Location: index.php');
}


function addCategory()
{
    $name        = $_POST['txtName'];
    $image       = $_FILES['fleImage'];
    $parentId    = $_POST['hidParentId'];
    
    $catImage = uploadImage('fleImage', SRV_ROOT . 'images/category/');
    
    $sql   = "INSERT INTO tbl_category (cat_parent_id, cat_name, cat_image) 
              VALUES ($parentId, '$name', '$catImage')";
    $result = dbQuery($sql) or die('Cannot add category' . mysql_error());
    
    header('Location: index.php?catId=' . $parentId);              
}

function uploadImage($inputName, $uploadDir)
{
    $image     = $_FILES[$inputName];
    $imagePath = '';

    if (trim($image['tmp_name']) != '') {

        $ext = substr(strrchr($image['name'], "."), 1); 

        $imagePath = md5(rand() * time()) . ".$ext";
        
		$size = getimagesize($image['tmp_name']);
		
		if ($size[0] > MAX_CATEGORY_IMAGE_WIDTH) {
			$imagePath = createThumbnail($image['tmp_name'], $uploadDir . $imagePath, MAX_CATEGORY_IMAGE_WIDTH);
		} else {
			if (!move_uploaded_file($image['tmp_name'], $uploadDir . $imagePath)) {
				$imagePath = '';
			}
		}	
    }

    
    return $imagePath;
}

function modifyCategory()
{
    $catId       = (int)$_GET['catId'];
    $name        = $_POST['txtName'];
    $image       = $_FILES['fleImage'];
    
    $catImage = uploadImage('fleImage', SRV_ROOT . 'images/category/');

    if ($catImage != '') {
        _deleteImage($catId);
		$catImage = "'$catImage'";
    } else {
		$catImage = 'cat_image';
	}
     
    $sql    = "UPDATE tbl_category 
               SET cat_name = '$name', cat_image = $catImage
               WHERE cat_id = $catId";
           
    $result = dbQuery($sql) or die('Cannot update category. ' . mysql_error());
    header('Location: index.php');              
}

function deleteCategory()
{
    if (isset($_GET['catId']) && (int)$_GET['catId'] > 0) {
        $catId = (int)$_GET['catId'];
    } else {
        header('Location: index.php');
    }

	$children = getChildren($catId);

	$categories  = array_merge($children, array($catId));
	$numCategory = count($categories);

	$sql = "SELECT pd_id, pd_image, pd_thumbnail
	        FROM tbl_product
			WHERE cat_id IN (" . implode(',', $categories) . ")";
	$result = dbQuery($sql);
	
	while ($row = dbFetchAssoc($result)) {
		@unlink(SRV_ROOT . PRODUCT_IMAGE_DIR . $row['pd_image']);	
		@unlink(SRV_ROOT . PRODUCT_IMAGE_DIR . $row['pd_thumbnail']);
	}

	$sql = "DELETE FROM tbl_product
			WHERE cat_id IN (" . implode(',', $categories) . ")";
	dbQuery($sql);

	_deleteImage($categories);

    $sql = "DELETE FROM tbl_category 
            WHERE cat_id IN (" . implode(',', $categories) . ")";
    dbQuery($sql);
    
    header('Location: index.php');
}

function getChildren($catId)
{
    $sql = "SELECT cat_id ".
           "FROM tbl_category ".
           "WHERE cat_parent_id = $catId ";
    $result = dbQuery($sql);
    
	$cat = array();
	if (dbNumRows($result) > 0) {
		while ($row = dbFetchRow($result)) {
			$cat[] = $row[0];

			$cat  = array_merge($cat, getChildren($row[0]));
		}
    }

    return $cat;
}

function deleteImage()
{
    if (isset($_GET['catId']) && (int)$_GET['catId'] > 0) {
        $catId = (int)$_GET['catId'];
    } else {
        header('Location: index.php');
    }
    
	_deleteImage($catId);

	$sql = "UPDATE tbl_category
			SET cat_image = ''
			WHERE cat_id = $catId";
	dbQuery($sql);        

    header("Location: index.php?view=modify&catId=$catId");
}

function _deleteImage($catId)
{

    $deleted = false;


    $sql = "SELECT cat_image 
            FROM tbl_category
            WHERE cat_id ";
	
	if (is_array($catId)) {
		$sql .= " IN (" . implode(',', $catId) . ")";
	} else {
		$sql .= " = $catId";
	}	

    $result = dbQuery($sql);
    
    if (dbNumRows($result)) {
        while ($row = dbFetchAssoc($result)) {
	        // delete the image file
    	    $deleted = @unlink(SRV_ROOT . CATEGORY_IMAGE_DIR . $row['cat_image']);
		}	
    }
    
    return $deleted;
}

?>