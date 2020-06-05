<?php require_once('views/partials/header.php'); ?>
<?php  use Webshop\AuthenticationManager, Webshop\Util;  ?>

<?php
    if (!AuthenticationManager::isAuthenticated()) {
        Util::redirect('?view=login');
    }
?>
<?php require_once('views/partials/footer.php'); ?>

