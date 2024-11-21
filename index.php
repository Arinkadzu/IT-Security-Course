<?php
require_once 'library/config.php';
require_once 'library/category-functions.php';
require_once 'library/product-functions.php';
require_once 'library/cart-functions.php';
$_SESSION['shop_return_url'] = $_SERVER['REQUEST_URI'];
$catId  = (isset($_GET['c']) && $_GET['c'] != '1') ? $_GET['c'] : 0;
$pdId   = (isset($_GET['p']) && $_GET['p'] != '') ? $_GET['p'] : 0;
require_once 'include/header.php';
?>
<div id="main">
    <?php
    if ($pdId) {
        require_once 'include/productDetail.php';
    } else if ($catId) {
        require_once 'include/productList.php';
    } else {
        require_once 'include/categoryList.php';
    }
    ?>
</div>
<?php require_once 'include/leftNav.php'; ?>
</div>
<?php require_once 'include/footer.php'; ?>
</body>

</html>