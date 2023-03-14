<?php

namespace App\Services;

use PDO;

class PDOLoader
{
    private static PDOLoader $instance;
    private PDO $db;

    private function __construct()
    {
        $this->setENV();
    }

    public static function getInstance(): self
    {
        if(!isset(self::$instance)){
            self::$instance = new self;
        }

        return self::$instance;
    }

    private function setENV(): void
    {
        try {
            $this->db = new PDO(
                'mysql:host='.$_ENV['MYSQL_HOST']. ';dbname='.$_ENV['MYSQL_DATABASE'],
                $_ENV['MYSQL_USER'],
                $_ENV['MYSQL_PASSWORD']
            );
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function getDB():PDO
    {
        return $this->db;
    }
}