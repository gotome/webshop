<?php use Webshop\Util, Data\DataManager; ?>

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
            <td>
                <strong>
                    <?php echo Util::escape($openList->getName()); ?>
                </strong>
            </td>
            <td>                
                <?php 
                    $name = DataManager::getUserById($openList->getOwnerId()); 
                    echo Util::escape(is_null($name) ? "" : $name->getUserName());
                ?>
            </td>
            <td>
                <?php 
                    $helperId = $openList->getHelperId(); 
                    $name = DataManager::getUserById(is_null($helperId) ? -1 : $helperId); 
                    echo Util::escape(is_null($name) ? "" : $name->getUserName());
                ?>
            </td>    
            <td>
                <?php echo Util::escape($openList->getEndDate()); ?>
            </td>    
            <td>
                <?php echo Util::escape(is_null($openList->getPaidPrice()) ? "" : $openList->getPaidPrice()); ?>
            </td>    
            <td>
                <?php echo Util::escape($openList->getState()); ?>
            </td>    
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>