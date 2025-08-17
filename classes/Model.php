<?php

/**
 * Model class for database interactions.
 * This class provides a base for models to interact with the database using PDO.
 */
class Model
{
    protected static $pdo;

    public static function setPDO(PDO $pdo)
    {
        self::$pdo = $pdo;
    }

    protected static function now()
    {
        return date('Y-m-d H:i:s');
    }
}

