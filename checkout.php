<?php
require_once 'library/config.php';
require_once 'library/cart-functions.php';
require_once 'library/checkout-functions.php';

if (isCartEmpty()) {

	header('Location: cart.php');
} else if (isset($_GET['step']) && (int)$_GET['step'] > 0 && (int)$_GET['step'] <= 3) {
	$step = (int)$_GET['step'];

	$includeFile = '';
	if ($step == 1) {
		$includeFile = 'shippingAndPaymentInfo.php';
		$pageTitle   = 'Оформление заказа - Шаг 1 из 2';
	} else if ($step == 2) {
		$includeFile = 'checkoutConfirmation.php';
		$pageTitle   = 'Оформление заказа - Шаг 2 из 2';
	} else if ($step == 3) {
		$orderId     = saveOrder();
		$orderAmount = getOrderAmount($orderId);
		
		$_SESSION['orderId'] = $orderId;

		if ($_POST['hidPaymentMethod'] == 'cod') {
			header('Location: success.php');
			exit;
		} else {
			$includeFile = 'paypal/payment.php';	
		}
	}
} else {

	header('Location: index.php');
}

require_once 'include/header.php';
?>
<script language="JavaScript" type="text/javascript" src="library/checkout.js"></script>
<?php
require_once "include/$includeFile";
require_once 'include/footer.php';
?>