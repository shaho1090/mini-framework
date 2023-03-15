<?php

namespace App\Services;

use SplFileObject;

class JsonFileNavigator
{
    private string $filePath;
    private string $filename;
    private SplFileObject $file;
    private string $data = '';
    private int $offset;
    private string $lastOffsetFile;

    public function __construct()
    {
        $this->lastOffsetFile = storage_path() . '/' . 'last_offset.txt';
    }

    public function navigate(string $filename): bool
    {
        $this->filename = $filename;
        $this->setFilePath();

        $this->file = new SplFileObject($this->filePath, 'rb');

        $this->setOffset();

        $this->file->seek($this->offset);

        if (!$this->file->valid()) {
            $this->resetOffset();
            return false;
        }

        $this->setLines();

        $this->storeOffset($this->offset++);
        $this->insertChunk();
        return true;
    }

    private function setFilePath(): void
    {
        $this->filePath = storage_path() . '/' . $this->filename;
    }

    private function insertChunk(): void
    {
        if (!empty($this->data)) {
            $importer = new FileImporter($this->data);
            $importer->import();
        }
    }

    private function setOffset(): void
    {
        $this->offset = $this->readOffset();
    }

    private function storeOffset($offset): void
    {
        store_file('last_offset.txt', $offset);
    }

    private function readOffset(): false|string
    {
        if (!file_exists($this->lastOffsetFile)) {
            $this->storeOffset(1);
        }

        $file = fopen($this->lastOffsetFile, 'rb');

        $offset = fgets($file);

        fclose($file);

        return $offset;
    }

    private function setLines(): void
    {
        do {
            $this->file->seek($this->offset);

            if (!$this->file->valid()) {
                break;
            }

            $this->data = $this->data . $this->file->current();

            $this->offset++;
        } while (strpos($this->file->current(), '}') !== 3);
    }

    private function resetOffset(): void
    {
        $this->storeOffset(1);
    }
}