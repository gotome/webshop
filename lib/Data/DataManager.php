<?php

namespace Data;

//use Log\ConsoleWrite;
//use Log\Log;
//use Webshop\Category;
//use Webshop\Book;
use Webshop\User;
use Webshop\Article;
//use Webshop\PagingResult;
use Webshop\ShoppingList;


class DataManager implements IDataManager
{

    private static $__connection;

    private static function getConnection()
    {

        if (!isset(self::$__connection)) {

            $type = 'mysql';
            $host = 'localhost';
            $name = 'fh_2020_scm4_S1810307037';
            $user = 'fh_2020_scm4';
            $pass = 'fh_2020_scm4';

            self::$__connection = new \PDO($type . ':host=' . $host . ';dbname=' . $name . ';charset=utf8', $user, $pass);
        }
        return self::$__connection;


    }

    public static function exposeConnection()
    {
        return self::getConnection();
    }


    private static function query($connection, $query, $parameters = [])
    {
        $connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        try {
            // SELECT * FROM book WHERE id = ? AND price > ?
            /*
             * $parameters = [1, 12.00]
             *
             */
            $statement = $connection->prepare($query);
            $i = 1;
            foreach ($parameters as $param) {
                if (is_int($param)) {
                    $statement->bindValue($i, $param, \PDO::PARAM_INT);
                }                
                if (is_string($param)) {
                    $statement->bindValue($i, $param, \PDO::PARAM_STR);
                }
                $i++;
            }
            $statement->execute();
        } catch (\Exception $e) {
            die ($e->getMessage());
        }
        return $statement;
    }


    private static function fetchObject($cursor)
    {
        return $cursor->fetch(\PDO::FETCH_OBJ);
    }

    private static function close($cursor)
    {
        $cursor->closeCursor();
    }

    private static function closeConnection()
    {
        self::$__connection = null;
    }

    private static function lastInsertId ($connection) {
        return $connection->lastInsertId();
    }

    /**
     * get the categories
     *
     * note: global …; -> suboptimal
     *
     * @return array of Category-items
     */
    public static function getHelpSeekerShoppingListsByState(int $helpSeekerId, string $state1 = '', string $state2 = ''): array
    {
        $resultList = [];
        $con = self::getConnection();
        $res = self::query($con, "
            SELECT id, ownerId, helperId, endDate, paidPrice, state, name
            FROM shoppinglist
            WHERE (ownerId = ? and (state = ? or state = ?))          
            ORDER BY endDate;
        ", [$helpSeekerId, $state1, $state2]);
        while ($cat = self::fetchObject($res)) {
            $resultList[] = new ShoppingList($cat->id, $cat->ownerId, 
                $cat->helperId, $cat->endDate , $cat->paidPrice, $cat->state, $cat->name
            );
        }
        self::close($res);
        self::closeConnection();
        return $resultList;
    }

        /**
     * get the categories
     *
     * note: global …; -> suboptimal
     *
     * @return array of Category-items
     */
    public static function getHelperShoppingListsByState(int $helperId, string $state1 = '', string $state2 = ''): array
    {
        $resultList = [];
        $con = self::getConnection();
        $res = self::query($con, "
            SELECT id, ownerId, helperId, endDate, paidPrice, state, name
            FROM shoppinglist
            WHERE (helperId = ? and (state = ? or state = ?))          
            ORDER BY endDate;
        ", [$helperId, $state1, $state2]);
        while ($cat = self::fetchObject($res)) {
            $resultList[] = new ShoppingList($cat->id, $cat->ownerId, 
                $cat->helperId, $cat->endDate , $cat->paidPrice, $cat->state, $cat->name
            );
        }
        self::close($res);
        self::closeConnection();
        return $resultList;
    }

    /**
     * get the categories
     *
     * note: global …; -> suboptimal
     *
     * @return array of Category-items
     */
    public static function getAllOpenShoppingLists(): array
    {
        $resultList = [];
        $con = self::getConnection();
        $res = self::query($con, "
            SELECT id, ownerId, helperId, endDate, paidPrice, state, name
            FROM shoppinglist
            WHERE state = 'new'        
            ORDER BY endDate;
        ");
        while ($cat = self::fetchObject($res)) {
            $resultList[] = new ShoppingList($cat->id, $cat->ownerId, 
                $cat->helperId, $cat->endDate , $cat->paidPrice, $cat->state, $cat->name
            );
        }
        self::close($res);
        self::closeConnection();
        return $resultList;
    }

    public static function getShoppingListById(int $shoppingListId)
    {
        $resultList = null; 
        $con = self::getConnection();
        $res = self::query($con, "
            SELECT id, ownerId, helperId, endDate, paidPrice, state, name
            FROM shoppinglist
            WHERE id = ?;
        ", [$shoppingListId]);
        while ($cat = self::fetchObject($res)) {
            $resultList = new ShoppingList($cat->id, $cat->ownerId, 
                $cat->helperId, $cat->endDate , $cat->paidPrice, $cat->state, $cat->name
            );
        }
        self::close($res);
        self::closeConnection();
        return $resultList;
    }

    public static function getArticleById(int $articleId)
    {
        $resultArticle = null; 
        $con = self::getConnection();
        $res = self::query($con, "
            SELECT id, shoppingListId, description, amount, highestPrice, deletedFlag, doneFlag
            FROM article
            WHERE id = ?;
        ", [$articleId]);
        while ($cat = self::fetchObject($res)) {
            $resultArticle = new Article($cat->id, $cat->shoppingListId, 
                                         $cat->description,$cat->amount, 
                                         $cat->highestPrice, $cat->deletedFlag, 
                                         $cat->doneFlag
                                    );
        }
        self::close($res);
        self::closeConnection();
        return $resultArticle;
    }

    public static function getArticles(int $shoppingListId) {
        $resultList = [];
        $con = self::getConnection();
        $res = self::query($con, "
            SELECT id, shoppingListId, description, amount, highestPrice, deletedFlag, doneFlag
            FROM article
            WHERE shoppingListId = ? AND deletedFlag = false;
        ", [$shoppingListId]);
        while ($cat = self::fetchObject($res)) {
            $resultList[] = new Article($cat->id, $cat->shoppingListId, $cat->description,$cat->amount, $cat->highestPrice, $cat->deletedFlag, $cat->doneFlag
            );
        }
        self::close($res);
        self::closeConnection();
        return $resultList;
    }

    public static function createArticle(int $shoppingListId, string $description, int $amount, $highestPrice) {
        $con = self::getConnection();
        $con->beginTransaction();
        try {
            self::query ($con, "
                INSERT INTO article( 
                    shoppingListId,
                    description, 
                    amount,
                    highestPrice
                ) VALUES (
                    ?, ?, ?, ?
                );
            ", [$shoppingListId, $description, $amount, $highestPrice]);

            $con->commit();
        }
        catch (\Exception $e) {
            $con->rollBack();
            $description = null; 
            $amount = null; 
            $highestPrice = null; 
        }
        self::closeConnection();
    }

    public static function createList(int $userId, string $name, $endDate) {
        $con = self::getConnection();
        $con->beginTransaction();

        try {

            self::query ($con, "
                INSERT INTO shoppingList ( 
                    ownerId,
                    name, 
                    endDate
                ) VALUES (
                    ?, ?, ?
                );
            ", [$userId, $name, $endDate]);

            $con->commit();
        }
        catch (\Exception $e) {
            $con->rollBack();
            $userId = null; 
            $name = null; 
            $endDate = null; 
        }
        self::closeConnection();
    }

    public static function deleteListEntry(int $shoppingListId) {
        $con = self::getConnection();
        $con->beginTransaction();

        try {
            self::query ($con, "
                UPDATE shoppingList 
                SET state = 'done'
                WHERE id = ?
            ", [$shoppingListId]);

            $con->commit();
        }
        catch (\Exception $e) {
            $con->rollBack();
            $shoppingListId = null; 
        }
        self::closeConnection();
    }

    public static function finishListEntry(int $shoppingListId, $paidPrice) {
        $con = self::getConnection();
        $con->beginTransaction();

        try {
            self::query ($con, "
                UPDATE shoppingList 
                SET state = 'done', paidPrice = ? 
                WHERE id = ?
            ", [$paidPrice, $shoppingListId]);

            $con->commit();
        }
        catch (\Exception $e) {
            $con->rollBack();
            $shoppingListId = null; 
        }
        self::closeConnection();
    }

    public static function publishListEntry(int $shoppingListId) {
        $con = self::getConnection();
        $con->beginTransaction();

        try {
            self::query ($con, "
                UPDATE shoppingList 
                SET state = 'new'
                WHERE id = ?
            ", [$shoppingListId]);

            $con->commit();
        }
        catch (\Exception $e) {
            $con->rollBack();
            $shoppingListId = null; 
        }
        self::closeConnection();
    }

    public static function takeListEntry(int $helperId, int $shoppingListId) {
        $con = self::getConnection();
        $con->beginTransaction();

        try {
            self::query ($con, "
                UPDATE shoppingList 
                SET helperId = ?, state = 'processing'
                WHERE id = ?
            ", [$helperId, $shoppingListId]);

            $con->commit();
        }
        catch (\Exception $e) {
            $con->rollBack();
            $shoppingListId = null; 
            $helperId = null; 
        }
        self::closeConnection();
    }

    public static function deleteArticleEntry(int $articleId) {
        $con = self::getConnection();
        $con->beginTransaction();

        try {
            self::query ($con, "
                UPDATE article 
                SET deletedFlag = true
                WHERE id = ?
            ", [$articleId]);

            $con->commit();
        }
        catch (\Exception $e) {
            $con->rollBack();
            $articleId = null; 
        }
        self::closeConnection();
    }

    public static function articleBoughtEntry(int $articleId) {
        $con = self::getConnection();
        $con->beginTransaction();

        try {
            self::query ($con, "
                UPDATE article 
                SET doneFlag = true
                WHERE id = ?
            ", [$articleId]);

            $con->commit();
        }
        catch (\Exception $e) {
            $con->rollBack();
            $articleId = null; 
        }
        self::closeConnection();
    }

    /**
     * get the User item by id
     *
     * @param integer $userId uid of that user
     * @return User | null
     */
    public static function getUserById(int $userId)
    { // no return type, cos "null" is not a valid User
        $user = null;
        $con = self::getConnection();
        $res = self::query($con, " 
            SELECT u.id, u.firstName, u.lastName, u.userName, u.passwordHash, r.bitCode, u.deletedFlag
            FROM user u JOIN role r ON u.roleId = r.id
            WHERE u.id = ?;      
        ", [$userId]);
        if ($u = self::fetchObject($res)) {
            $user = new User($u->id, 
                $u->firstName, $u->lastName, 
                $u->userName, $u->passwordHash, 
                $u->bitCode, $u->deletedFlag
            );
        }
        
        self::close($res);
        self::closeConnection($con);
        return $user;
    }

    /**
     * get the User item by name
     *
     * note: show for case sensitive and insensitive options
     *
     * @param string $userName name of that user - must be exact match
     * @return User | null
     */
    public static function getUserByUserName(string $userName)
    { 
        $user = null;
        $con = self::getConnection();
        $res = self::query($con, " 
            SELECT u.id, u.firstName, u.lastName, u.userName, u.passwordHash, r.bitCode, u.deletedFlag
            FROM user u JOIN role r ON u.roleId = r.id
            WHERE u.userName = ?;
        ", [$userName]);
        if ($u = self::fetchObject($res)) {
            $user = new User($u->id, 
            $u->firstName, $u->lastName, 
            $u->userName, $u->passwordHash, 
            $u->bitCode, $u->deletedFlag
        );
        }
        self::close($res);
        self::closeConnection($con);
        return $user;
    }

}
