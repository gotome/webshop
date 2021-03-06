<?php 

use Data\DataManager;
use Webshop\AuthenticationManager; 
use Webshop\Util; 

$user = AuthenticationManager::getAuthenticatedUser();
$userId = isset($user) ? $user->getId() : null; 
$Lists = (isset($userId) && ((int) $userId > 0)) ? DataManager::getAllOpenShoppingLists() : null;

if (!AuthenticationManager::isAuthenticated()) {      
    Util::redirect("index.php?view=login");        
}

require_once('views/partials/header.php'); ?>
<div class="page-header">
    <h2>Alle freigegebenen Listen</h2>
</div>  

    
<?php if (isset($Lists)) : ?>
    <?php
    if (sizeof($Lists) > 0) :
        require('views/partials/shoppinglist.php');
    else :
        ?>
        <div class="alert alert-warning" role="alert">Keine freigegebenen Listen vorhanden</div>
    <?php endif; ?>
<?php endif; ?>


<?php require_once('views/partials/footer.php'); ?>
