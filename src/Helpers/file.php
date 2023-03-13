<?php

if (!function_exists('json_validator')) {
    function json_validator($data): bool
    {
        if (!empty($data)) {
            return is_string($data) && is_array(json_decode($data, true));
        }

        return false;
    }
}

if (!function_exists('is_json')) {
    function is_json($path): bool
    {
        return pathinfo($path, PATHINFO_EXTENSION) === 'json';
    }
}