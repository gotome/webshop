<?php require_once('views/partials/header.php'); ?>
<?php  use Bookshop\AuthenticationManager; ?>

<div class="page-header">
    <h2>Welcome</h2>
</div>

<p>webshop</p>

<?php
    if (!AuthenticationManager::isAuthenticated()) {
        require_once('views/login.php');
    }
?>
<?php require_once('views/partials/footer.php'); ?>

