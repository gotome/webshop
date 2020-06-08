<?php 

use Data\DataManager;

$Lists = DataManager::getClosedShoppingLists();

require_once('views/partials/header.php'); ?>
<div class="page-header">
    <h2>Alle erledigten Listen</h2>
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


