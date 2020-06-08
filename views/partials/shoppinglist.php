<?php 
    require_once('views/partials/header.php');
    use Webshop\Util, Data\DataManager, Webshop\AuthenticationManager, Webshop\RoleType; 
    $user = AuthenticationManager::getAuthenticatedUser();
    use Webshop\ShoppingListStatus; 
?>

<table class="table table-striped">
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
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($Lists as $List):
        ?>
        <tr>
            <td>
                <strong>
                    <?php echo Util::escape($List->getName()); ?>
                </strong>
            </td>
            <td>                
                <?php 
                    $name = DataManager::getUserById($List->getOwnerId()); 
                    echo Util::escape(is_null($name) ? "" : $name->getUserName());
                ?>
            </td>
            <td>
                <?php 
                    $helperId = $List->getHelperId(); 
                    $name = DataManager::getUserById(is_null($helperId) ? -1 : $helperId); 
                    echo Util::escape(is_null($name) ? "" : $name->getUserName());
                ?>
            </td>    
            <td>
                <?php echo Util::escape($List->getEndDate()); ?>
            </td>    
            <td>
                <?php echo Util::escape(is_null($List->getPaidPrice()) ? "" : $List->getPaidPrice()); ?>
            </td>    
            <?php  if ($user != NULL && $user->hasRole(RoleType::HELPSEEKER)) { ?> 
                <?php if ($List->getState() == ShoppingListStatus::NEW_STATE || $List->getState() == ShoppingListStatus::UNPUBLISHED_STATE) { ?>
                    <td class="add-remove">
                        <form method="post" action="<?php echo Util::action(Webshop\Controller::ACTION_EDIT_ARTICLE, 
                            array(Webshop\Controller::SHOPPING_LIST_ID => $List->getId())
                        );?>">
                            <button type="submit" role="button" class="btn btn-default btn-xs btn-success">
                                <span class="glyphicon glyphicon-edit"></span>
                            </button>
                        </form>
                        <form method="post" action="<?php echo Util::action(Webshop\Controller::ACTION_DELETE_LIST, 
                            array(Webshop\Controller::SHOPPING_LIST_ID => $List->getId())
                        );?>">
                            <button type="submit" role="button" class="btn btn-default btn-xs btn-success">
                                <span class="glyphicon glyphicon-minus"></span>
                            </button>
                        </form>
                    </td>
                    <?php if ($List->getState() == 'unpublished') { ?>
                    <td class="add-remove">
                        <form method="post" action="<?php echo Util::action(Webshop\Controller::ACTION_PUBLISH_LIST, 
                            array(Webshop\Controller::SHOPPING_LIST_ID => $List->getId())
                        );?>">
                            <div class="border">
                                <div class="text-center">
                                    <button type="submit" role="button" class="btn btn-primary">Freigeben</button>
                                </div>
                            </div>
                        </form>
                    </td>
                    <?php } else { ?>
                        <td class="add-remove">
                        <form method="post">
                            <div class="border">
                                <div class="text-center">
                                    <button type="submit" role="button" class="btn btn-secondary">Freigegeben</button>
                                </div>
                            </div>
                        </form>
                    </td>
                    <?php }  ?>
                <?php } ?>
            <?php } ?>            
            <?php  if ($user != NULL && $user->hasRole(RoleType::HELPER)) { ?> 
                <?php if ($List->getState() == ShoppingListStatus::NEW_STATE) { ?>
                    <td class="add-remove">
                        <form method="post" action="<?php echo Util::action(Webshop\Controller::ACTION_SHOW_ARTICLE, 
                            array(Webshop\Controller::SHOPPING_LIST_ID => $List->getId())
                        );?>">
                            <button type="submit" role="button" class="btn btn-default btn-xs btn-success">
                                <span class="glyphicon glyphicon-eye-open"></span>
                            </button>
                        </form>
                    </td>
                    <td class="add-remove">
                        <form method="post" action="<?php echo Util::action(Webshop\Controller::ACTION_TAKE_LIST, 
                            array(Webshop\Controller::SHOPPING_LIST_ID => $List->getId())
                        );?>">
                            <div class="border">
                                <div class="text-center">
                                    <button type="submit" role="button" class="btn btn-primary">Übernehmen</button>
                                </div>
                            </div>
                        </form>
                    </td>
                <?php } ?>
                <?php if ($List->getState() == ShoppingListStatus::PROCESSING_STATE) { ?>
                    <td class="add-remove">
                        <form method="post" action="<?php echo Util::action(Webshop\Controller::ACTION_SHOW_ARTICLE, 
                            array(Webshop\Controller::SHOPPING_LIST_ID => $List->getId())
                        );?>">
                            <button type="submit" role="button" class="btn btn-default btn-xs btn-success">
                                <span class="glyphicon glyphicon-edit"></span>
                            </button>
                        </form>
                    </td>
                <?php } ?>
            <?php } ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

