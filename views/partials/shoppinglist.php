<?php use Webshop\Util, Webshop\ShoppingCart; ?>

<table class="table">
    <thead>
    <tr>
        <th>
            Name
        </th>
        <th>
            Hilfesuchender
        </th>
        <th>
            Freiwilliger
        </th>
        <th>
            Enddatum
        </th>
        <th>
            Maximalpreis
        </th>
        <th>
            Status
        </th>
        <th>
            <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>
        </th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($openLists as $openList):
        $inCart = ShoppingCart::contains($openList->getId());
        ?>
        <tr>
            <td><strong>
                    <?php echo Util::escape($openList->getTitle()); ?>
                </strong>
            </td>
            <td>
                <?php echo Util::escape($openList->getAuthor()); ?>
            </td>
            <td>
                <?php // echo money_format('%i', Util::escape($openList->getPrice()));
                echo Util::escape($openList->getPrice());
                ?>
            </td>
            <td class="add-remove">
                <?php  if ($inCart): ?>
                    <form method="post" action="<?php echo Util::action
                    (Webshop\Controller::ACTION_REMOVE, array('openListId' => $openList->getId())); ?>">
                    <button type="submit" role="button" class="btn btn-default btn-xs btn-info">
                        <span class="glyphicon glyphicon-minus"></span>
                    </button>
                    </form>
                <?php else: ?>
                    <form method="post" action="<?php echo Util::action
                     (Webshop\Controller::ACTION_ADD, array('openListId' => $openList->getId())); ?>">
                        <button type="submit" role="button" class="btn btn-default btn-xs btn-success">
                            <span class="glyphicon glyphicon-plus"></span>
                        </button>
                    </form>
                <?php endif;  ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>