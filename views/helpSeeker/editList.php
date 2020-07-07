<?php 

use Webshop\Util;
use Data\DataManager;
use Webshop\RoleType; 
use Webshop\AuthenticationManager; 

$list = DataManager::getShoppingListById($_GET['shoppingListId']); 
$articles = DataManager::getArticles($_GET['shoppingListId']);

$user = AuthenticationManager::getAuthenticatedUser();
if (isset($user) ? !$user->hasRole(RoleType::HELPSEEKER) : true) {    
    Util::redirect("index.php?view=login");     
}


require_once('views/partials/header.php'); ?>
<div class="page-header">
    <h2><?php echo Util::escape($list->getName()); ?></h2>  
</div>  

<form class="form-horizontal" method="post" action="<?php echo Util::action(Webshop\Controller::ACTION_ADD_ARTICLE, array('view' => $view)); ?>">
    <input type="text" hidden name="<?php echo Webshop\Controller::SHOPPING_LIST_ID; ?>" value="<?php echo $_GET['shoppingListId']; ?>" />
      <div class="form-group">
        <label for="inputName" class="col-sm-2 control-label">Name:</label>
        <div class="col-sm-6">
            <input type="text" minlength="1" maxlength="100" class="form-control" id="inputName" name="<?php echo Webshop\Controller::ARTICLE_NAME; ?>" placeholder="Artikelname" >
        </div>
    </div>
    <div class="form-group">
        <label for="inputAmount" class="col-sm-2 control-label">Menge:</label>
        <div class="col-sm-6">
            <input type="number" min="0.0" max="9999" class="form-control" id="endDate" name="<?php echo Webshop\Controller::ARTICLE_AMOUNT; ?>" placeholder="Menge">
        </div>
    </div>
    <div class="form-group">
        <label for="inputHighestPrice" class="col-sm-2 control-label">Höchstpreis:</label>
        <div class="col-sm-6">
            <input type="number" step="0.01" min="0.0" max="999.99" class="form-control" id="endDate" name="<?php echo Webshop\Controller::ARTICLE_HIGHEST_PRICE; ?>" placeholder="Höchstpreis">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-6">
            <button type="submit" class="btn btn-default">hinzufügen</button>
        </div>
    </div>
</form>
    
<?php if (isset($articles)) : ?>
    <?php
    if (sizeof($articles) > 0) :   
        require('views/partials/editListTable.php');
    else :
        ?>
        <div class="alert alert-warning" role="alert">Keine Artikel vorhanden</div>
    <?php endif; ?>
<?php endif; ?>

<?php
require_once('views/partials/footer.php'); ?>