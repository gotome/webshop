<?php


namespace Webshop;
use Log\Logger; 


class Controller extends BaseObject
{
    const ACTION = 'action';
    const PAGE = 'page';
    //const CC_NAME = 'nameOnCard';
    //const CC_NUMBER = 'cardNumber';
    const ACTION_ADD_LIST = 'addList';
    //const ACTION_REMOVE = 'removeFromCart';
    const ACTION_LOGIN = 'login';
    const ACTION_LOGOUT = 'logout';
    //const ACTION_ORDER = 'placeOrder';
    const ACTION_ADD_ARTICLE = 'addArticle';
    const ACTION_EDIT_ARTICLE = 'editArticle'; 
    const ACTION_DELETE_ARTICLE = 'deleteArticle'; 
    const ACTION_DELETE_LIST = 'deleteList'; 
    const USER_NAME = 'userName';
    const USER_PASSWORD = 'password';
    const SHOPPING_LIST_ID = 'shoppingListId';
    const SHOPPING_LIST_NAME = 'name';
    const SHOPPING_LIST_END_DATE = 'enddate';
    const ARTICLE_ID = 'articleId';
    const ARTICLE_NAME = 'articleName';
    const ARTICLE_AMOUNT = 'articleamount';
    const ARTICLE_HIGHEST_PRICE = 'highestPrice';
    const ACTION_PUBLISH_LIST = 'publishList'; 


    private static $instance = false;

    public static function getInstance() : Controller {
        if (!self::$instance) {
            self::$instance = new Controller();
        }
        return self::$instance;
    }

    private function __construct() {}


    public function invokePostAction () : bool {

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            throw new \Exception('Controller can only handle Post Requests');
            return null;
        }
        elseif (!isset($_REQUEST[self::ACTION])) {
            throw new \Exception(self::ACTION . ' not specified.');
            return null;
        }

        $action = $_REQUEST[self::ACTION];

        switch ($action) {
            case self::ACTION_PUBLISH_LIST : 
                $user = AuthenticationManager::getAuthenticatedUser();
                if ($user == null) {
                    $this->forwardRequest(['Not logged in.']);
                }  
                $shoppingListId = $_REQUEST[self::SHOPPING_LIST_ID]; 
                if (!$this->publishList($shoppingListId)) {
                    $this->forwardRequest(['publish list failed']);
                }
                Util::redirect();
                break; 
            
            case self::ACTION_EDIT_ARTICLE :
                $user = AuthenticationManager::getAuthenticatedUser();
                if ($user == null) {
                    $this->forwardRequest(['Not logged in.']);
                }         
                $shoppingListId = $_REQUEST[self::SHOPPING_LIST_ID];
                Util::redirect('index.php?view=editList&shoppingListId=' . rawurlencode($shoppingListId));
                break; 
            
            case self::ACTION_DELETE_LIST: 
                $user = AuthenticationManager::getAuthenticatedUser();
                if ($user == null) {
                    $this->forwardRequest(['Not logged in.']);
                }  
                $shoppingListId = $_REQUEST[self::SHOPPING_LIST_ID]; 
                if (!$this->deleteList($shoppingListId)) {
                    $this->forwardRequest(['Delete list failed']);
                }
                Util::redirect();
                
                break; 
            case self::ACTION_DELETE_ARTICLE: 
                $user = AuthenticationManager::getAuthenticatedUser();
                if ($user == null) {
                    $this->forwardRequest(['Not logged in.']);
                }  
                $articleId = $_REQUEST[self::ARTICLE_ID]; 
                if (!$this->deleteArticle($articleId)) {
                    $this->forwardRequest(['Delete article failed']);
                }
                Util::redirect();
                
                break; 
            case self::ACTION_ADD_LIST : 
                $user = AuthenticationManager::getAuthenticatedUser();
                if ($user == null) {
                    $this->forwardRequest(['Not logged in.']);
                }               
                $name = $_POST[self::SHOPPING_LIST_NAME];
                $endDate = $_POST[self::SHOPPING_LIST_END_DATE];
                if (!$this->addList($name, $endDate)) {
                    $this->forwardRequest(['Add list failed']);
                }
                Util::redirect();
                break;
            case self::ACTION_ADD_ARTICLE:
                $user = AuthenticationManager::getAuthenticatedUser();
                if ($user == null) {
                    $this->forwardRequest(['Not logged in.']);
                } 
                $shoppingListId = $_POST[self::SHOPPING_LIST_ID];
                $name = $_POST[self::ARTICLE_NAME];
                $amount = $_POST[self::ARTICLE_AMOUNT];
                $highestPrice = $_POST[self::ARTICLE_HIGHEST_PRICE];
                if (!$this->addArticle($shoppingListId, $name, $amount, $highestPrice)) {
                    $this->forwardRequest(['Add article failed']);   
                }
                break;
                /*
            case self::ACTION_REMOVE :
                ShoppingCart::remove((int) $_REQUEST['bookId']);
                Util::redirect();
                break; 
                */
            case self::ACTION_LOGIN :
                if (!AuthenticationManager::authenticate($_REQUEST[self::USER_NAME], $_REQUEST[self::USER_PASSWORD])) {     
                    $this->forwardRequest(array('Falscher Beutzername oder Passwort'));
                }
                
                Logger::Write("ACTION: LOGIN"); 
                Util::redirect();
                break;

            case self::ACTION_LOGOUT :
                //sign out current user
                
                Logger::Write("ACTION: LOGOUT"); 
                AuthenticationManager::signOut();
                Util::redirect();
                break;
/*
            case self::ACTION_ORDER :
                $user = AuthenticationManager::getAuthenticatedUser();
                if ($user == null) {
                    $this->forwardRequest(['Not logged in.']);
                }
                if (!$this->processCheckout($_POST[self::CC_NAME], $_POST[self::CC_NUMBER])) {
                    $this->forwardRequest(['Checkout failed']);
                }
                break;
*/
            default :
                throw new \Exception('Unknown controller action: ' . $action);
                return null;
                break;

        }

    }

    protected function addList(string $name = null, $endDate) {
        $errors = [];

        if ($name == null || strlen($name) == 0) {
            $errors[] = 'Invalid name';
        }

        if ($endDate == null || !strtotime($endDate)) {
            $errors[] = 'Invalid date';
        }

        if (sizeof($errors) > 0) {
            $this->forwardRequest($errors);
            return false;
        }

        $user = AuthenticationManager::getAuthenticatedUser();
        Logger::Write("ACTION: ADD LIST LIST_NAME = {$name}");         
        \Data\DataManager::createList($user->getId(), $name, $endDate);

        Util::redirect('index.php?view=openLists');
        return true;
    }

    protected function deleteList(int $shoppingListId) {
        $errors = [];

        if ($shoppingListId == null || $shoppingListId < 0) {
            $errors[] = 'Invalid shopping list id';
        }

        if (sizeof($errors) > 0) {
            $this->forwardRequest($errors);
            return false;
        }
        $shoppingList = \Data\DataManager::getShoppingListById($shoppingListId);         
        $name = $shoppingList->getName(); 
        Logger::Write("ACTION: DELETE LIST LIST_NAME = {$name}"); 

        \Data\DataManager::deleteListEntry($shoppingListId);        
        return true;
    }

    protected function publishList(int $shoppingListId) {
        $errors = [];

        if ($shoppingListId == null || $shoppingListId < 0) {
            $errors[] = 'Invalid shopping list id';
        }

        if (sizeof($errors) > 0) {
            $this->forwardRequest($errors);
            return false;
        }
        $shoppingList = \Data\DataManager::getShoppingListById($shoppingListId);         
        $name = $shoppingList->getName(); 
        Logger::Write("ACTION: PUBLISH LIST LIST_NAME = {$name}"); 

        \Data\DataManager::publishListEntry($shoppingListId);        
        return true;
    }

    protected function deleteArticle(int $articleId) {
        $errors = [];

        if ($articleId == null || $articleId < 0) {
            $errors[] = 'Invalid article id';
        }

        if (sizeof($errors) > 0) {
            $this->forwardRequest($errors);
            return false;
        }
      
        $article = \Data\DataManager::getArticleById($articleId); 
        $name = $article->getDescription(); 
        Logger::Write("ACTION: DELETE ARTICLE ARTICLE_NAME = {$name}"); 

        \Data\DataManager::deleteArticleEntry($articleId);   
        
        return true;
    }

    protected function addArticle(int $shoppingListId, string $name, int $amount, $highestPrice) {
        $errors = [];

        if ($shoppingListId == null || $shoppingListId < 0) {
            $errors[] = 'Invalid shopping list id';
        }

        if ($name == null || strlen($name) == 0) {
            $errors[] = 'Invalid name';
        }

        if ($amount == null || !is_integer($amount)) {
            $errors[] = 'Invalid amount';
        }

        if ($highestPrice == null || !is_numeric($highestPrice)) {
            $errors[] = 'Invalid highest price';
        }


        if (sizeof($errors) > 0) {
            $this->forwardRequest($errors);
            return false;
        }

        Logger::Write("ACTION: ADD ARTICLE ARTICLE_NAME = {$name}"); 
        \Data\DataManager::createArticle($shoppingListId, $name, $amount, $highestPrice); 

        Util::redirect();
        return true;
    }


    /**
     *
     * @param array $errors : optional assign it to
     * @param string $target : url for redirect of the request
     */
    protected function forwardRequest(array $errors = null, $target = null) {
        //check for given target and try to fall back to previous page if needed
        if ($target == null) {
            if (!isset($_REQUEST[self::PAGE])) {
                throw new Exception('Missing target for forward.');
            }
            $target = $_REQUEST[self::PAGE];
        }
        //forward request to target
        // optional - add errors to redirect and process them in view
        if (count($errors) > 0)
            $target .= '&errors=' . urlencode(serialize($errors));
        header('location: ' . $target);
        exit();
    }


}