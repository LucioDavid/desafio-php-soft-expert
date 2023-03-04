<?php

namespace Src\Core\Database;

use PDO;
use PDOException;
use Src\Core\Application;

class DBDriver
{
    private ?PDO $db = null;

    public function __construct()
    {
        $dsn = match ($_ENV['DB_CONNECTION']) {
            'mysql' => "{$_ENV['DB_CONNECTION']}:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_DATABASE']}",
            'pgsql' => "{$_ENV['DB_CONNECTION']}:host={$_ENV['DB_HOST']};port={$_ENV['DB_PORT']};dbname={$_ENV['DB_DATABASE']}",
            default => null
        };

        if ($dsn === null) {
            exit("Database \"{$_ENV['DB_CONNECTION']}\" is not supported.");
        }

        $this->db = new PDO($dsn, $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
    }

    public function initDB()
    {
        $sql = file_get_contents(dirname(__DIR__) . "/Database/schema.{$_ENV['DB_CONNECTION']}.sql");
        try {
            $this->db->exec($sql);
        } catch (PDOException $e) {
            echo $e->getMessage();
            die;
        }
    }

    public function getConnection()
    {
        return $this->db;
    }
}
