<?php

namespace App\Controller;

use App\Attributes\Post;
use App\Attributes\Route;
use App\Jobs\ImportFileJob;

class ImportFileController
{
    #[Route('/')]
    public function index()
    {
        return 'Home';
    }

    /**
     * @throws \Exception
     */
    #[Post('/import-file')]
    public function store(): string
    {
        $this->validateFile();

        try {
            move_file_to_storage($_FILES['file']);

            dispatch_job( importFileJob::class, $_FILES['file']['name']);

            return 'The file has been moved to the storage directory and is ready to start importing!';
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    private function validateFile(): void
    {
        if (!isset($_FILES['file'])) {
            throw new \Error('"File" key is required!', 403);
        }

        $file = $_FILES['file'];

        if (!is_json($file['name'])) {
            throw new \Error('The file type is not json!', 403);
        }
    }
}