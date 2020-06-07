<?php

namespace Data;

interface IDataManager {
    //public static function getCategories() : array;
    //public static function getBooksByCategory(int $categoryId) : array;
    public static function getUserById(int $userId);
    public static function getUserByUserName(string $userName);
    public static function getOpenShoppingLists(); 
    public static function getArticles(int $shoppingListId);
    public static function createList(int $userId, string $name, $endDate);
    //public static function createOrder(int $userId, array $bookIds, string $nameOnCard, string $cardNumber) : int;
}

/*
interface IDataManager {
    public static function getUsers() : array;
    public static function getArticlesByList(int $ListId) : array;
    public static function getUserById(int $UserId);
    public static function getUserByUserName(string $UserName);
    public static function createShoppingList(string $name, string $endDate, float $paidPrice) : int;
    public static function createArticle() : int;
}
*/