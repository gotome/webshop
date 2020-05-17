<?php 

use Data\DataManager;

$openLists = (isset($categoryId) && ((int) $categoryId > 0)) ? DataManager::getOpenShoppingLists() : null;


require_once('views/partials/header.php'); ?>
<div class="page-header">
    <h2>Offene Listen</h2>
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

<?php require_once('views/partials/footer.php'); ?>

