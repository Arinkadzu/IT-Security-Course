<?php

if (strpos($_SERVER['REMOTE_ADDR'], '66.135.197.') === false) {
	exit;
}

require_once './paypal.inc.php';


$result = fsockPost($paypal['url'], $_POST); 


if (eregi("VERIFIED", $result)) { 
	
        require_once '../../library/config.php';
            

        $sql = "SELECT od_status
                FROM tbl_order
                WHERE od_id = {$_POST['invoice']}";

        $result = dbQuery($sql);


        if (dbNumRows($result) == 0) {
            exit;
        } else {
        
            $row = dbFetchAssoc($result);
            

            if ($row['od_status'] !== 'New') {
                exit;
            } else {


                $sql = "SELECT SUM(pd_price * od_qty) AS subtotal
                        FROM tbl_order_item oi, tbl_product p
                        WHERE oi.od_id = {$_POST['invoice']} AND oi.pd_id = p.pd_id
                        GROUP by oi.od_id";
                $result = dbQuery($sql);
                $row    = dbFetchAssoc($result);		
                
                $subTotal = $row['subtotal'];
                $total    = $subTotal + $shopConfig['shippingCost'];
                            
                if ($_POST['payment_gross'] != $total) {
                    exit;
                } else {
                   
					$invoice = $_POST['invoice'];
					$memo    = $_POST['memo'];
					if (!get_magic_quotes_gpc()) {
						$memo = addslashes($memo);
					}
					

                    $sql = "UPDATE tbl_order
                            SET od_status = 'Paid', od_memo = '$memo', od_last_update = NOW()
                            WHERE od_id = $invoice";
                    $result = dbQuery($sql);
                }
            }
        }

} else { 
	exit;
} 


?>

