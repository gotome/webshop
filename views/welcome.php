<?php require_once('views/partials/header.php'); ?>
<?php  use Webshop\AuthenticationManager, Webshop\Util;  ?>

<?php
    if (!AuthenticationManager::isAuthenticated()) {
        Util::redirect('?view=login');
    }
?>

<div style="background-image: url('assets/pictures/HomeBackground.jpg');">

<style>
body {
  background-image: url('assets/pictures/HomeBackground.jpg');
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-size: 100% 100%;
}
</style>

<?php require_once('views/partials/footer.php'); ?>

