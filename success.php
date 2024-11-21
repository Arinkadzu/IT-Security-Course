<?php
require_once 'library/config.php';
if (!isset($_SESSION['orderId'])) {
	header('Location: ' . WEB_ROOT);
	exit;
}

$pageTitle   = 'Оформление заказа выполнено успешно!';
require_once 'include/header.php';

if ($shopConfig['sendOrderEmail'] == 'y') {
	$subject = "[New Order] " . $_SESSION['orderId'];
	$email   = $shopConfig['email'];
	$message = "You have a new order. Check the order detail here \n http://" . $_SERVER['HTTP_HOST'] . WEB_ROOT . 'admin/order/index.php?view=detail&oid=' . $_SESSION['orderId'] ;
	mail($email, $subject, $message, "From: $email\r\nReturn-path: $email");
}


unset($_SESSION['orderId']);
?>
<p>&nbsp;</p><table width="500" border="0" align="center" cellpadding="1" cellspacing="0">
   <tr> 
      <td align="left" valign="top" bgcolor="#333333"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr> 
               <td align="center" bgcolor="#EEEEEE"> <p>&nbsp;</p>
                        <p>Спасибо за покупку! Чтобы вернуться на главную страницу,
						<a href="index.php">нажмите сюда.</a></p>
                  <p>&nbsp;</p></td>
            </tr>
         </table></td>
   </tr>
</table>
<br>
<br>
<?php
require_once 'include/footer.php';
?>