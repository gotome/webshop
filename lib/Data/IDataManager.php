<?php

namespace Data;

interface IDataManager {
    public static function getUsers() : array;
    public static function getArticlesByList(int $ListId) : array;
    public static function getUserById(int $UserId);
    public static function getUserByUserName(string $UserName);
    public static function createShoppingList(string $name, string $endDate, float $paidPrice) : int;
    public static function createArticle() : int;
}