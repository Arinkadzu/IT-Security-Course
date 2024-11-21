<?php
if (!defined('WEB_ROOT')) {
	exit;
}

if (isset($_GET['productId']) && $_GET['productId'] > 0) {
	$productId = $_GET['productId'];
} else {

	header('Location: index.php');
}

$sql = "SELECT cat_name, pd_name, pd_description, pd_price, pd_qty, pd_image
        FROM tbl_product pd, tbl_category cat
		WHERE pd.pd_id = $productId AND pd.cat_id = cat.cat_id";
$result = dbQuery($sql) or die('Cannot get product. ' . mysql_error());

$row = dbFetchAssoc($result);
extract($row);

if ($pd_image) {
	$pd_image = 'images/product/' . $pd_image;
} else {
	$pd_image = 'images/no-image-large.png';
}


?>
<p>&nbsp;</p>
<form action="processProduct.php?action=addProduct" method="post" enctype="multipart/form-data" name="frmAddProduct" id="frmAddProduct">
 <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="entryTable">
  <tr> 
   <td width="150" class="label">Category</td>
   <td class="content"><?php echo $cat_name; ?></td>
  </tr>
  <tr> 
   <td width="150" class="label">Product Name</td>
   <td class="content"> <?php echo $pd_name; ?></td>
  </tr>
  <tr> 
   <td width="150" class="label">Description</td>
   <td class="content"><?php echo nl2br($pd_description); ?> </td>
  </tr>
  <tr> 
   <td width="150" height="36" class="label">Price</td>
   <td class="content"><?php echo number_format($pd_price, 2); ?> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Qty In Stock</td>
   <td class="content"><?php echo number_format($pd_qty); ?> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Image</td>
   <td class="content"><img src="<?php echo $pd_image; ?>"></td>
  </tr>
 </table>
 <p align="center"> 
  <input name="btnModifyProduct" type="button" id="btnModifyProduct" value="Modify Product" onClick="window.location.href='index.php?view=modify&productId=<?php echo $productId; ?>';" class="box">
  &nbsp;&nbsp;
  <input name="btnBack" type="button" id="btnBack" value=" Back " onClick="window.history.back();" class="box">
 </p>
</form>
