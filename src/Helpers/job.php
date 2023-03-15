<?php

if (!function_exists('dispatch_job')) {
    function dispatch_job(string $job, string $data): void
    {
        $query = 'INSERT INTO jobs (name, payload) values (?,?)';
        $statement = get_db()->prepare($query);
        $statement->execute([$job, $data]);
    }
}