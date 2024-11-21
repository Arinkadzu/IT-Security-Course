<?php
require_once 'config.php';

function formatCategories($categories, $parentId)
{

	$navCat = array();

	$ids = array();
	foreach ($categories as $category) {
		if ($category['cat_parent_id'] == $parentId) {
			$navCat[] = $category;
		}

		$ids[$category['cat_id']] = $category;
	}	

	$tempParentId = $parentId;

	while ($tempParentId != 0) {
		$parent    = array($ids[$tempParentId]);
		$currentId = $parent[0]['cat_id'];

		$tempParentId = $ids[$tempParentId]['cat_parent_id'];
		foreach ($categories as $category) {

			if ($category['cat_parent_id'] == $tempParentId && !in_array($category, $parent)) {
				$parent[] = $category;
			}
		}

		array_multisort($parent);

		$n = count($parent);
		$navCat2 = array();
		for ($i = 0; $i < $n; $i++) {
			$navCat2[] = $parent[$i];
			if ($parent[$i]['cat_id'] == $currentId) {
				$navCat2 = array_merge($navCat2, $navCat);
			}
		}
		
		$navCat = $navCat2;
	}


	return $navCat;
}


function getCategoryList()
{
	$sql = "SELECT cat_id, cat_name, cat_image
	        FROM tbl_category
			WHERE cat_parent_id = 0
			ORDER BY cat_name";
    $result = dbQuery($sql);
    
    $cat = array();
    while ($row = dbFetchAssoc($result)) {
		extract($row);
		
		if ($cat_image) {
			$cat_image = 'images/category/' . $cat_image;
		} else {
			$cat_image = 'images/no-image-small.png';
		}
		
		$cat[] = array('url'   => $_SERVER['PHP_SELF'] . '?c=' . $cat_id,
		               'image' => $cat_image,
					   'name'  => $cat_name);

    }
	
	return $cat;			
}

function getChildCategories($categories, $id, $recursive = true)
{
	if ($categories == NULL) {
		$categories = fetchCategories();
	}
	
	$n     = count($categories);
	$child = array();
	for ($i = 0; $i < $n; $i++) {
		$catId    = $categories[$i]['cat_id'];
		$parentId = $categories[$i]['cat_parent_id'];
		if ($parentId == $id) {
			$child[] = $catId;
			if ($recursive) {
				$child   = array_merge($child, getChildCategories($categories, $catId));
			}	
		}
	}
	
	return $child;
}

function fetchCategories()
{
    $sql = "SELECT cat_id, cat_parent_id, cat_name, cat_image
	        FROM tbl_category
			ORDER BY cat_id, cat_parent_id ";
    $result = dbQuery($sql);
    
    $cat = array();
    while ($row = dbFetchAssoc($result)) {
        $cat[] = $row;
    }
	
	return $cat;
}

?>