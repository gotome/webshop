<?php

use Webshop\Util, Webshop\AuthenticationManager, Webshop\RoleType;
$user = AuthenticationManager::getAuthenticatedUser();

if (isset($_GET['errors'])) {
    $errors = unserialize(urldecode($_GET['errors']));
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <title>Simple Shopping</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="assets/main.css" rel="stylesheet">

</head>

<body>
    <div class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>                
                
                <a class="navbar-brand"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Simple Shopping</a>
            </div>

            <div class="navbar-collapse collapse" id="bs-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li <?php if ($view === 'welcome') { ?>class="active" <?php } ?>><a href="index.php">Startseite</a></li>             
                    <!-- help seeker -->
                    <?php  if ($user != NULL && $user->hasRole(RoleType::HELPSEEKER)) { ?> 
                        <li <?php if ($view === 'createShoppingList') { ?>class="active" <?php } ?>><a href="index.php?view=helpSeeker/createShoppingList">Neue Liste</a></li>    
                        <li <?php if ($view === 'openLists') { ?>class="active" <?php } ?>><a href="index.php?view=helpSeeker/openLists">Offene Listen</a></li>              
                        <li <?php if ($view === 'listsInProcess') { ?>class="active" <?php } ?>><a href="index.php?view=helpSeeker/listsInProcess">Listen in Arbeit</a></li>         
                        <li <?php if ($view === 'closedLists') { ?>class="active" <?php } ?>><a href="index.php?view=helpSeeker/closedLists">Erledigte Listen</a></li>                               
                    <?php  } ?>
                    <!-- helper -->
                    <?php  if ($user != NULL && $user->hasRole(RoleType::HELPER)) { ?> 
                        <li <?php if ($view === 'publishedLists') { ?>class="active" <?php } ?>><a href="index.php?view=helper/publishedLists">Freigegebene Listen</a></li>  
                        <li <?php if ($view === 'takenLists') { ?>class="active" <?php } ?>><a href="index.php?view=helper/takenLists">Abzuarbeitende Listen</a></li>       
                        <li <?php if ($view === 'finishedLists') { ?>class="active" <?php } ?>><a href="index.php?view=helper/finishedLists">Abgearbeite Listen</a></li>                            
                    <?php  } ?>
                    <!-- admin -->
                    <!-- not yet implemented -->
                </ul>
                <ul class="nav navbar-nav navbar-right login">
                    <li class="dropdown">
                        <?php if ($user == null) : ?>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                Nicht eingeloggt!
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="index.php?view=login">Einloggen</a>
                                </li>
                            </ul>
                        <?php else : ?>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                Eingeloggt als: <span class="badge"><?php echo Util::escape($user->getUserName()); ?></span>
                                <b class="caret"></b>
                            </a>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li class="centered">
                                    <form method="post" action="<?php echo Util::action(Webshop\Controller::ACTION_LOGOUT); ?>">
                                        <input class="btn btn-xs" role="button" type="submit" value="Logout" />
                                    </form>
                                </li>
                            </ul>
                        <?php endif;  ?>
                    </li>
                </ul>
                <!-- /. login -->
            </div>
            <!--/.nav-collapse -->
        </div>
    </div>
    <div class="container">

</body>