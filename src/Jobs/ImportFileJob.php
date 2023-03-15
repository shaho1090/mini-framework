<?php

namespace App\Jobs;

use App\Services\JsonFileNavigator;

class ImportFileJob implements JobInterface
{
    private string $filename;
    private JsonFileNavigator $jsonFileNavigator;

    public function __construct(string $filename)
    {
        $this->filename = $filename;
        $this->jsonFileNavigator = new JsonFileNavigator();
    }

    public function handle(): void
    {
        $result = $this->jsonFileNavigator->navigate($this->filename);

        if($result === false){
            $this->removeTheJobFromDatabase();
        }
    }

    private function removeTheJobFromDatabase()
    {
        $query = 'DELETE FROM jobs WHERE name=? and payload = ?';
        $statement = get_db()->prepare($query);
        $statement->execute([get_class($this),$this->filename]);
    }
}