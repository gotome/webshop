<?php

namespace Data;

interface IDataManager {
    public static function getUserById(int $userId);
    public static function getUserByUserName(string $userName);
    public static function getArticles(int $shoppingListId);
    public static function createList(int $userId, string $name, $endDate);
    public static function createArticle(int $shoppingListId, string $description, int $amount, $highestPrice); 
    public static function getShoppingListById(int $shoppingListId); 
    public static function getHelpSeekerShoppingListsByState(int $helpSeekerId, string $state1 = '', string $state2 = ''): array; 
    public static function getHelperShoppingListsByState(int $helperId, string $state1 = '', string $state2 = ''): array; 
    public static function deleteListEntry(int $shoppingListId); 
    public static function deleteArticleEntry(int $articleId); 
    public static function getArticleById(int $articleId);
    public static function getAllOpenShoppingLists(): array; 
    public static function takeListEntry(int $helperId, int $shoppingListId);  
    public static function publishListEntry(int $shoppingListId); 
}
