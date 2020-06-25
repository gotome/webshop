<?php

use Webshop\Util;
use Webshop\AuthenticationManager; 

$name = $_REQUEST[Webshop\Controller::SHOPPING_LIST_NAME] ?? null;
$date = $_REQUEST[Webshop\Controller::SHOPPING_LIST_END_DATE] ?? null;

if (!AuthenticationManager::isAuthenticated()) {      
    Util::redirect("index.php?view=login");        
}


require_once('views/partials/header.php');
?>

<div class="page-header">
    <h2>Einkaufsliste erstellen</h2>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        Please fill out the form below:
    </div>
    <div class="panel-body">

        <form class="form-horizontal" method="post" action="<?php echo Util::action(Webshop\Controller::ACTION_ADD_LIST, array('view' => $view)); ?>">
            <div class="form-group">
                <label for="inputName" class="col-sm-2 control-label">Name:</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="inputName" name="<?php echo Webshop\Controller::SHOPPING_LIST_NAME; ?>" placeholder="Listenname" value="<?php echo htmlentities($name); ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword" class="col-sm-2 control-label">Enddatum:</label>
                <div class="col-sm-6">
                    <input type="date" class="form-control" id="endDate" name="<?php echo Webshop\Controller::SHOPPING_LIST_END_DATE; ?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-6">
                    <button type="submit" class="btn btn-default">Erstellen</button>
                </div>
            </div>
        </form>

    </div>
</div>


<?php require_once('views/partials/footer.php');
