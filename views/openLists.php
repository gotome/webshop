<?php 

use Data\DataManager;

$openLists = DataManager::getOpenShoppingLists();

require_once('views/partials/header.php'); ?>
<div class="page-header">
    <h2>Alle offenen Listen</h2>
</div>  

    
<?php if (isset($openLists)) : ?>
    <?php
    if (sizeof($openLists) > 0) :
        require('views/partials/shoppinglist.php');
    else :
        ?>
        <div class="alert alert-warning" role="alert">No open Lists</div>
    <?php endif; ?>
<?php endif; ?>


