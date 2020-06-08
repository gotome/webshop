<?php

namespace Data;

interface IDataManager {
    public static function getUserById(int $userId);
    public static function getUserByUserName(string $userName);
    public static function getOpenShoppingLists(): array;
    public static function getArticles(int $shoppingListId);
    public static function createList(int $userId, string $name, $endDate);
    public static function createArticle(int $shoppingListId, string $description, int $amount, $highestPrice); 
    public static function getShoppingListById(int $shoppingListId); 
    public static function deleteListEntry(int $shoppingListId); 
    public static function deleteArticleEntry(int $articleId); 
    public static function getArticleById(int $articleId);
    public static function getClosedShoppingLists(): array; 
    public static function getInProcessShoppingLists(): array; 
    public static function publishListEntry(int $shoppingListId); 
}
