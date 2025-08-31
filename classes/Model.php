<?php

/**
 * Model class for database interactions.
 * This class provides a base for models to interact with the database using PDO.
 */
class Model
{
    private static $pdo;


    protected static function getPDO(): PDO
    {
        if (!self::$pdo) {
            self::$pdo = require __DIR__ . '/../db_connection.php';
        }
        return self::$pdo;
    }


    public static function setPDO(PDO $pdo)
    {
        self::$pdo = $pdo;
    }

    protected static function now()
    {
        return date('Y-m-d H:i:s');
    }
}

