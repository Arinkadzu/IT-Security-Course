<table width="100%" border="0" cellspacing="0" cellpadding="20">
<?php 
if ($numProduct > 0 ) {
$i = 0;
while ($row = dbFetchAssoc($result)) {
extract($row);
if ($pd_thumbnail) {
$pd_thumbnail = 'images/product/' . $pd_thumbnail;
} else {
$pd_thumbnail = 'images/no-image-small.png';
}
if ($i % $productsPerRow == 0) {
echo '<tr>';
}
$pd_price = displayAmount($pd_price);
echo "<td width=\"$columnWidth%\" align=\"center\"><a href=\"" . $_SERVER['PHP_SELF'] . "?c=$catId&p=$pd_id" . "\"><img src=\"$pd_thumbnail\" border=\"0\"><br>$pd_name</a><br>Цена: $pd_price";
if ($pd_qty <= 0) {
echo "<br>Нет в наличии";
}
echo "</td>\r\n";
if ($i % $productsPerRow == $productsPerRow - 1) {
echo '</tr>';
}
$i += 1;
}
if ($i % $productsPerRow > 0) {
echo '<td colspan="' . ($productsPerRow - ($i % $productsPerRow)) . '">&nbsp;</td>';
}
} else {
?>
<tr>
<td width="100%" align="center" valign="center">Продукты в данной категории отсутствуют</td>
</tr>
<?php	
}	
?>
</table>
<p align="center"><?php echo $pagingLink; ?></p>