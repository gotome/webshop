<?php 

use Webshop\AuthenticationManager, Webshop\Util;
use Data\DataManager;

$articles = DataManager::getArticles($_GET['shoppingListId']);

require_once('views/partials/header.php'); ?>
<div class="page-header">
    <h2>Alle offenen Listen</h2>
</div>  

<form class="form-horizontal" method="post" action="<?php echo Util::action(Webshop\Controller::ACTION_ADD_ARTICLE, array('view' => $view)); ?>">
    <input type="text" hidden name="<?php echo Webshop\Controller::SHOPPING_LIST_ID; ?>" value="<?php echo $_GET['shoppingListId']; ?>" />
      <div class="form-group">
        <label for="inputName" class="col-sm-2 control-label">Name:</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="inputName" name="<?php echo Webshop\Controller::ARTICLE_NAME; ?>" placeholder="Artikel" >
        </div>
    </div>
    <div class="form-group">
        <label for="inputPassword" class="col-sm-2 control-label">Menge:</label>
        <div class="col-sm-6">
            <input type="number" class="form-control" id="endDate" name="<?php echo Webshop\Controller::ARTICLE_QTY; ?>">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-6">
            <button type="submit" class="btn btn-default">Erstellen</button>
        </div>
    </div>
</form>
    
<?php if (isset($articles)) : ?>
    <?php
    if (sizeof($articles) > 0) :
        var_dump($articles);
    else :
        ?>
        <div class="alert alert-warning" role="alert">No articles</div>
    <?php endif; ?>
<?php endif; ?>

<?php
require_once('views/partials/footer.php'); ?>