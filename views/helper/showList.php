<?php 

use Webshop\Util;
use Data\DataManager;

$list = DataManager::getShoppingListById($_GET['shoppingListId']); 

$articles = DataManager::getArticles($_GET['shoppingListId']);
require_once('views/partials/header.php'); ?>

<div class="page-header">
    <h2><?php echo $list->getName() ?></h2>  
</div>  

<?php  if ($user != NULL && $user->getId() == $list->getHelperId()) { ?> 
    <form class="form-horizontal" method="post" action="<?php echo Util::action(Webshop\Controller::ACTION_LIST_FINISHED, array('view' => $view)); ?>">
        <input type="text" hidden name="<?php echo Webshop\Controller::SHOPPING_LIST_ID; ?>" value="<?php echo $_GET['shoppingListId']; ?>" />
        <div class="form-group">
            <label for="inputHighestPrice" class="col-sm-2 control-label">Gesamtpreis:</label>
            <div class="col-sm-6">
                <input type="number" step="0.01" class="form-control" id="endDate" name="<?php echo Webshop\Controller::SHOPPING_LIST_PAID_PRICE; ?>" placeholder="Gesamtpreis">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-6">
                <button type="submit" class="btn btn-primary">Erledigt</button>
            </div>
        </div>
    </form>
<?php } ?> 

<div>   
    <h3>Artikel:</h3>
</div>

    
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