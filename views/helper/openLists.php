<?php 

use Data\DataManager;
use Webshop\ShoppingListStatus; 
use Webshop\AuthenticationManager; 
use Webshop\Util; 
use Webshop\RoleType; 

$user = AuthenticationManager::getAuthenticatedUser();
$userId = isset($user) ? $user->getId() : null; 

if (isset($user) ? !$user->hasRole(RoleType::HELPER) : true) {    
    Util::redirect("index.php?view=login");     
}

$Lists = (isset($userId) && ((int) $userId > 0)) ? DataManager::getHelpSeekerShoppingListsByState($userId, ShoppingListStatus::NEW_STATE, ShoppingListStatus::UNPUBLISHED_STATE) : null;

require_once('views/partials/header.php'); ?>
<div class="page-header">
    <h2>Offenen Listen</h2>
</div>  

    
<?php if (isset($Lists)) : ?>
    <?php
    if (sizeof($Lists) > 0) :
        require('views/partials/shoppinglist.php');
    else :
        ?>
        <div class="alert alert-warning" role="alert">Keine offenen Listen vorhanden</div>
    <?php endif; ?>
<?php endif; ?>


<?php require_once('views/partials/footer.php'); ?>
