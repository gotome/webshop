<?php 

use Data\DataManager;
use Webshop\ShoppingListStatus; 
use Webshop\AuthenticationManager; 

$user = AuthenticationManager::getAuthenticatedUser();
$userId = isset($user) ? $user->getId() : null; 
$Lists = (isset($userId) && ((int) $userId > 0)) ? DataManager::getHelperShoppingListsByState($userId, ShoppingListStatus::DONE_STATE) : null;


require_once('views/partials/header.php'); ?>
<div class="page-header">
    <h2>Abgearbeitete Listen</h2>
</div>  

    
<?php if (isset($Lists)) : ?>
    <?php
    if (sizeof($Lists) > 0) :
        require('views/partials/shoppinglist.php');
    else :
        ?>
        <div class="alert alert-warning" role="alert">Keine erledigten Listen vorhanden</div>
    <?php endif; ?>
<?php endif; ?>

<?php require_once('views/partials/footer.php'); ?>