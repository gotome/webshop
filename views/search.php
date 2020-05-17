<?php 

use Data\DataManager;
use Webshop\Util;

$categories = DataManager::getCategories();
$categoryId = $_REQUEST['categoryId'] ?? null;
$books = (isset($categoryId) && ((int) $categoryId > 0)) ? DataManager::getBooksByCategory((int) $categoryId) : null;


require_once('views/partials/header.php'); ?>
<div class="page-header">
    <h2>Offene Listen</h2>
</div>  

    
<?php if (isset($books)) : ?>
    <?php
    if (sizeof($books) > 0) :
        require('views/partials/shoppinglist.php');
    else :
        ?>
        <div class="alert alert-warning" role="alert">No books in this category.</div>
    <?php endif; ?>
<?php else : ?>
    <div class="alert alert-info" role="alert">Please select a category.</div>
<?php endif; ?>

<?php require_once('views/partials/footer.php'); ?>

