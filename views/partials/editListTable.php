<?php use Webshop\Util, Data\DataManager; 
require_once('views/partials/header.php');

?>

<table class="table table-striped">
    <thead>
    <tr>
        <th>
            Name
        </th>
        <th>
            Menge
        </th>
        <th>
            Höchstpreis
        </th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($articles as $article):
        ?>
        <tr>
            <td>
                <strong>
                    <?php echo Util::escape($article->getDescription()); ?>
                </strong>
            </td>
            <td>                
                <?php 
                    echo Util::escape($article->getAmount());
                ?>
            </td>
            <td>
                <?php 
                    echo Util::escape($article->getHighestPrice());
                ?>
            </td>    
            <td class="add-remove">
                <form method="post" action="<?php echo Util::action(Webshop\Controller::ACTION_DELETE_ARTICLE, 
                    array(Webshop\Controller::ARTICLE_ID => $article->getId())
                );?>">
                    <button type="submit" role="button" class="btn btn-default btn-xs btn-success">
                        <span class="glyphicon glyphicon-minus"></span>
                    </button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php require_once('views/partials/footer.php'); ?>