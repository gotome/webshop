<?php

use Bookshop\Util;

$title  = isset($_REQUEST['title']) ?
    $_REQUEST['title'] :
    null;
$offset = isset($_REQUEST['offset']) ?
    $_REQUEST['offset'] :
    0;
$epp    = isset($_REQUEST['epp']) ?
    $_REQUEST['epp'] :
    4;  // epp … entries per page

$page = isset($title) ?
    Data\DataManager::getBooksForSearchCriteriaWithPaging($title, $offset, $epp) :
    null;

require_once('views/partials/header.php');
?>

    <div class="page-header">
        <form class="form-horizontal" action="index.php" method="get">
            <input type="hidden" name="view" value="<?php echo $view; ?>" />
            <div class="input-group">
                <input type="text" class="form-control" id="title" name="title" placeholder="Search books by title..." value="<?php print htmlentities($title); ?>">
                <div class="input-group-btn">
                    <button type="submit" class="btn btn-default">Search</button>
                </div>
            </div>

        </form>
    </div>


<?php if (isset($page)): ?>

    <h3>Search Result</h3>

    <?php if (sizeof($page->getResult()) > 0) : ?>

        <p>
            Displaying results <?php echo Util::escape($page->getPositionOfFirst()); ?> to <?php echo Util::escape
            ($page->getPositionOfLast()); ?> of <?php echo Util::escape($page->getTotalCount()); ?>.
        </p>

        <?php
        $books = $page->getResult();
        require('views/partials/booklist.php');
        ?>

        <p>
            <?php
            $p = 0;
            $i = 0;
            while ($i < $page->getTotalCount()) :
                ?>
                <a href="?view=search&title=<?php echo rawurlencode($title); ?>&offset=<?php echo rawurlencode($i); ?>&epp=<?php echo rawurlencode($epp); ?>"><?php echo Util::escape(++$p); ?></a>
                <?php
                $i += $epp;
            endwhile;
            ?>
        </p>

    <?php else : ?>
        <p>No matching books found.</p>
    <?php endif; ?>

<?php endif; ?>

<?php require_once('views/partials/footer.php');