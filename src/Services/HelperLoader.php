<?php

namespace App\Services;

class HelperLoader
{
    private string $directory = __DIR__ . '/../Helpers';

    public function __construct()
    {
        $this->loadHelperFunctions();
    }

    private function loadHelperFunctions(): void
    {
        $files = scandir($this->directory);

        foreach ($files as $file) {
            if ($file === '.' || $file === '..' || is_dir($file)) {
                continue;
            }

            require_once($this->directory.'/'.$file);
        }
    }
}