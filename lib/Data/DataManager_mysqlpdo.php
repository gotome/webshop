<?php

namespace Data;

use Bookshop\Category;
use Bookshop\Book;
use Bookshop\User;
use Bookshop\PagingResult;


class DataManager implements IDataManager
{

    private static $__connection;

    private static function getConnection()
    {

        if (!isset(self::$__connection)) {

            $type = 'mysql';
            $host = 'localhost';
            $name = 'fh_scm4_bookshop';
            $user = 'root';
            $pass = '';

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
    public static function getCategories(): array
    {
        $categories = [];
        $con = self::getConnection();
        $res = self::query($con, "
            SELECT id, name 
            FROM categories;
        ");

        while ($cat = self::fetchObject($res)) {
            $categories[] = new Category($cat->id, $cat->name);
        }
        self::close($res);
        self::closeConnection();
        return $categories;

    }

    /**
     * get the books per category
     *
     * @param integer $categoryId numeric id of the category
     * @return array of Book-items
     */
    public static function getBooksByCategory(int $categoryId): array
    {
        $books = [];
        $con = self::getConnection();
        $res = self::query($con, "
            SELECT id, categoryId, title, author, price  
            FROM books 
            WHERE categoryId = ?;
        ", [$categoryId]);

        while ($book = self::fetchObject($res)) {
            $books[] = new Book($book->id, $book->categoryId, $book->title, $book->author, $book->price);
        }
        self::close($res);
        self::closeConnection();
        return $books;


    }

    /**
     * get the books per search term
     *
     * note: stripos() – returns index (also 0!) on success and -1 on error
     * 0 == false but 0 === true -> thus test for !== false
     *
     * "This function may return Boolean FALSE, but may also return a
     * non-Boolean value which evaluates to FALSE. Please read the section
     * on Booleans for more information. Use the === operator for testing
     * the return value of this function." -- http://php.net/manual/en/function.stripos.php
     *
     * @param string $term search term: book title string match
     * @return array of Book-items
     */
    public static function getBooksForSearchCriteria(string $term): array
    {
        $books = [];
        $con = self::getConnection();
        $res = self::query($con, "
          SELECT id, categoryId, title, author, price 
          FROM books 
          WHERE title LIKE ?;
          ", ["%" . $term . "%"]);
        while ($book = self::fetchObject($res)) {
            $books[] = new Book($book->id, $book->categoryId, $book->title, $book->author, $book->price);
        }
        self::close($res);
        self::closeConnection($con);
        return $books;

    }

    /**
     * get the books per search term – paginated set only
     *
     * @param string $term  search term: book title string match
     * @param integer $offset  start at the nth item
     * @param integer $numPerPage  number of items per page
     * @return array of Book-items
     */
    public static function getBooksForSearchCriteriaWithPaging($term, $offset, $numPerPage) {
        $con = self::getConnection();
        //query total count
        $res = self::query($con, "
          SELECT COUNT(*) AS cnt 
          FROM books 
          WHERE title LIKE ?;
      ", ["%" . $term . "%"]);
        $totalCount = self::fetchObject($res)->cnt;
        self::close($res);
        //query books to return
        $books = [];
        $res = self::query($con, "
          SELECT id, categoryId, title, author, price 
          FROM books 
          WHERE title 
          LIKE ? LIMIT ?, ?;
      ", ["%" . $term . "%", intval($offset), intval($numPerPage)]);
        while ($book = self::fetchObject($res)) {
            $books[] = new Book($book->id, $book->categoryId, $book->title, $book->author, $book->price);
        }
        self::close($res);
        self::closeConnection($con);
        return new PagingResult($books, $offset, $totalCount);
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
            SELECT id, userName, passwordHash 
            FROM users 
            WHERE id = ?;
        ", [$userId]);
        if ($u = self::fetchObject($res)) {
            $user = new User($u->id, $u->userName, $u->passwordHash);
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
            SELECT id, userName, passwordHash 
            FROM users 
            WHERE userName = ?;
        ", [$userName]);
        if ($u = self::fetchObject($res)) {
            $user = new User($u->id, $u->userName, $u->passwordHash);
        }
        self::close($res);
        self::closeConnection($con);
        return $user;
    }

    /**
     * place to order with the shopping cart items
     *
     * note: nothing to do here without the database
     * random order id can be used to demonstrate that POST is only executed once
     *
     * @param integer $userId id of the ordering user
     * @param array $bookIds integers of book ids
     * @param string $nameOnCard cc name
     * @param string $cardNumber cc number
     * @return integer
     */
    public static function createOrder(int $userId, array $bookIds, string $nameOnCard, string $cardNumber): int
    {
        $con = self::getConnection();
        $con->beginTransaction();

        try {

            self::query ($con, "
                INSERT INTO orders ( 
                    userId, 
                    creditCardNumber, 
                    creditCardHolder
                ) VALUES (
                    ?, ?, ? 
                );
            ", [$userId, $cardNumber, $nameOnCard]);

            $orderId = self::lastInsertId($con);
            foreach ($bookIds as $bookId) {
                self::query($con, "
                    INSERT INTO orderedbooks (
                        orderId, 
                        bookId 
                    ) VALUES (
                        ?,? 
                    );", [$orderId, $bookId]);
            }
            $con->commit();
        }
        catch (\Exception $e) {
            $con->rollBack();
            $orderId = null;
        }
        self::closeConnection();
        return $orderId;

    }
}
