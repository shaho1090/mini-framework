<?php

namespace App\Services;

class JobSeeker
{
    private mixed $jobs;

    public function seek(): bool
    {
        $query = 'SELECT * FROM jobs';
        $statement = get_db()->prepare($query);
        $statement->execute();
        $this->jobs = $statement->fetch();

        return (bool)$this->jobs;
    }

    public function run(): void
    {
        if($this->jobs){
            $job = new $this->jobs['name']($this->jobs['payload']);
            $job->handle();
        }
    }
}