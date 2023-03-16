<?php

if (!function_exists('storage_path')) {
    function storage_path(): string
    {
        if (!file_exists(__DIR__ .'/../../storage')) {
            mkdir(__DIR__ . '/../../storage', 0777, true);
        }

        return __DIR__ . '/../../storage';
    }
}

if (!function_exists('move_file_to_storage')) {
    function move_file_to_storage(array $file_data): void
    {
        $filePath = storage_path() . '/' . $file_data['name'];

        move_uploaded_file($file_data['tmp_name'], $filePath);
    }
}

if (!function_exists('store_file')) {
    function store_file(string $name, string $data): void
    {
        $filePath = storage_path() . '/' . $name;

        $file =fopen($filePath, "w");

        fwrite($file, $data);

        fclose($file);
    }
}