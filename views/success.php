<?php

$orderId = $_REQUEST['orderId'] ?? null;
require_once ('views/partials/header.php');
?>

<div class="page-header">
    <h2>Success!</h2>
    <p>Thank you for your order</p>

    <?php if ($orderId != null) { ?>
    <p>Your order number: <?php echo \Bookshop\Util::escape($orderId); ?></p>

    <?php } ?>
</div>

<?php
require_once ('views/partials/footer.php');
?>
