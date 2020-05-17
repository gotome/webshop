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
            Bezahlter Preis
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
        ?>
        <tr>
            <td><strong>
                    <?php echo Util::escape($openList->getName()); ?>
                </strong>
            </td>
            <td>
                <?php echo Util::escape($openList->getOwnerId()); ?>
            </td>
            <td>
                <?php echo Util::escape($openList->getHelperId()); ?>
            </td>    
            <td>
                <?php echo Util::escape($openList->getEndDate()); ?>
            </td>    
            <td>
                <?php echo Util::escape($openList->getPaidPrice()); ?>
            </td>    
            <td>
                <?php echo Util::escape($openList->getState()); ?>
            </td>    
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>