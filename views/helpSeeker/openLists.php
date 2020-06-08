<?php 

use Data\DataManager;

$Lists = DataManager::getOpenShoppingLists();

require_once('views/partials/header.php'); ?>
<div class="page-header">
    <h2>Alle offenen Listen</h2>
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


