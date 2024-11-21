<h3 align="center"><?php echo $pd_name; ?></h3>
<p align="center"><img src="<?php echo $pd_image; ?>" border="0" alt="<?php echo $pd_name; ?>"></p>
<p align="left"><?php echo $pd_description; ?></p>
<p align="center">Цена: <?php echo displayAmount($pd_price); ?></p>
<p align="center">
<?php
if ($pd_qty > 0) {
?>
<input type="button" name="btnAddToCart" value="Добавить в корзину &gt;" onClick="window.location.href='<?php echo $cart_url; ?>';" class="addToCartButton">
<?php
} else {
	echo 'Нет в наличии';
}
?>
</p>







