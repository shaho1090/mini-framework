<?php

namespace App\Model;

class Product
{
    private string $table = 'products';
    private \PDO $db;
    private string $query;
    private \PDOStatement|false $statement;

    public function __construct()
    {
        $this->db = get_db();
    }

    public function insert(array $data): void
    {
        $this->setInsertQuery();
        $this->setStatement();
        $this->executeQuery($data);
    }

    private function setInsertQuery()
    {
        $this->query = 'INSERT INTO '.$this->table.' 
        (id, nr, name, product_url,search_keywords,description,brand) 
        VALUES (:id, :nr, :name, :product_url, :search_keywords, :description, :brand) ';

        var_dump($this->query);
    }

    private function setStatement(): void
    {
        $this->statement = $this->db->prepare($this->query);
    }

    private function executeQuery($data): void
    {
        $this->statement->execute([
            ':id' => $data['id'],
            ':nr' => $data['nr'],
            ':name' => $data['name'],
            ':product_url' => $data['product_url'],
            ':search_keywords' => $data['search_keywords'],
            ':description' => $data['description'],
            ':brand' => $data['brand']
        ]);
    }
}