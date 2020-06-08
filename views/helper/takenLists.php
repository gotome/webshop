<?php 

use Data\DataManager;
use Webshop\ShoppingListStatus; 
use Webshop\AuthenticationManager; 

$user = AuthenticationManager::getAuthenticatedUser();
$userId = $user->getId(); 
$Lists = DataManager::getHelperShoppingListsByState($userId, ShoppingListStatus::PROCESSING_STATE);

require_once('views/partials/header.php'); ?>
<div class="page-header">
    <h2>Abzuarbeitende Listen</h2>
</div>  

    
<?php if (isset($Lists)) : ?>
    <?php
    if (sizeof($Lists) > 0) :
        require('views/partials/shoppinglist.php');
    else :
        ?>
        <div class="alert alert-warning" role="alert">Keine abzuarbeitenden Listen vorhanden</div>
    <?php endif; ?>
<?php endif; ?>


<?php require_once('views/partials/footer.php'); ?>
