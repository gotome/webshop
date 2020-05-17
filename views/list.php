<?php 

use Data\DataManager;
use Webshop\Util;

$categories = DataManager::getCategories();
$categoryId = $_REQUEST['categoryId'] ?? null;
$books = (isset($categoryId) && ((int) $categoryId > 0)) ? DataManager::getBooksByCategory((int) $categoryId) : null;


require_once('views/partials/header.php'); ?>
<div class="page-header">
    <h2>List of books category</h2>
</div>

<ul class="nav nav-tabs">
    <?php foreach ($categories as $cat) { ?>
        <li role="presentation"
            <?php if ($cat->getId() === (int) $categoryId) { ?> class="active" <?php } ?>
            >
            <a href="<?php echo $_SERVER['PHP_SELF'] ?>?view=list&categoryId=<?php echo urlencode($cat->getId()); ?>"><?php echo Util::escape($cat->getName()); ?></a>
        </li>
    <?php } ?>    
</ul> 
    
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

