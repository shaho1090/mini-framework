<?php

if (!function_exists('get_db')) {
    function get_db(): PDO
    {
       return \App\Services\PDOLoader::getInstance()->getDB();
    }
}