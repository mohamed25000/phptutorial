<?php

namespace App;

use PDO;

/**
 * @mixin PDO
 */

class DB
{
    private static ?PDO $pdo = null;
    public function __construct(array $config)
    {
        $defaultOptions = [
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_DEFAULT_FETCH_MODE =>PDO::FETCH_ASSOC,
        ];
        if(! static::$pdo) {
            try {

                static::$pdo = new PDO(
                    $config["driver"] . ':host=' . $config["host"] .
                    ';dbname=' . $config["database"],
                    $config["user"],
                    $config["pass"],
                    $config["options"] ?? $defaultOptions
                );
                //$this->pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            } catch (\PDOException $ex) {
                throw new \PDOException($ex->getMessage(), (int)$ex->getCode());
            }
        }
    }

    public static function getPdo(): ?PDO
    {
        return static::$pdo;
    }

    public function __call(string $name, array $arguments)
    {
        call_user_func_array([static::$pdo, $name], $arguments);
    }
}