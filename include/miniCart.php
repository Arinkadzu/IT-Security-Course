<?php
if (!defined('WEB_ROOT')) {
	exit;
}

$cartContent = getCartContent();

$numItem = count($cartContent);	
?>
<table width="100%" border="0" cellspacing="2" cellpadding="2">
 <?php
if ($numItem > 0) {
?>
<?php
	$subTotal = 0;
	for ($i = 0; $i < $numItem; $i++) {
		extract($cartContent[$i]);
		$pd_name = "$ct_qty x $pd_name";
		$url = "index.php?c=$cat_id&p=$pd_id";
		
		$subTotal += $pd_price * $ct_qty;
?>
 <tr>
   <td><a href="<?php echo $url; ?>"><?php echo $pd_name; ?></a></td>
   
  <td width="30%" align="right"><?php echo displayAmount($ct_qty * $pd_price); ?></td>
 </tr>
<?php
	} // end while
?>
  <tr><td align="left">Товаров на</td>
  <td width="30%" align="right"><?php echo displayAmount($subTotal); ?></td>
 </tr>
  <tr><td align="left">Доставка</td>
  <td width="30%" align="right"><?php echo displayAmount($shopConfig['shippingCost']); ?></td>
 </tr>
  <tr><td align="left">Всего</td>
  <td width="30%" align="right"><?php echo displayAmount($subTotal + $shopConfig['shippingCost']); ?></td>
 </tr>
  <tr><td colspan="2">&nbsp;</td></tr>
  <tr>
  <td colspan="2" align="center"><a href="cart.php?action=view">Оформить заказ</a></td>
 </tr>  
<?php	
} else {
?>
  <tr><td colspan="2" align="center" valign="middle">Корзина пуста</td></tr>
<?php
}
?> 
</table>
