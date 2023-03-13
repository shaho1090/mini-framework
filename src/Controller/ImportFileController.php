<?php

namespace App\Controller;

use App\Attributes\Post;
use App\Attributes\Route;

class ImportFileController
{
    #[Route('/')]
    public function index()
    {
        return 'Hey There!';
    }

    #[Post('/import-file')]
    public function store()
    {
        return 'Import File';
    }
}