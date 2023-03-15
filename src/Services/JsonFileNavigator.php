<?php

namespace App\Services;

use SplFileObject;

class JsonFileNavigator
{
    private string $filePath;
    private string $filename;
    private SplFileObject $file;
    private array $lines;
    private int $offset;

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
        $this->insertChunk($this->lines);
        return true;
    }

    private function setFilePath(): void
    {
        $this->filePath = storage_path() . '/' . $this->filename;
    }

    private function insertChunk(array $lines): void
    {
//        var_dump($this->lines);
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
        $file = fopen(storage_path().'/'.'last_offset.txt', 'rb');

        if(!$file){
            $this->storeOffset(1);
            $this->readOffset();
        }

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

            $this->lines[] = $this->file->current();

            $this->offset++;
            var_dump($this->offset);
        } while (strpos($this->file->current(), '},') !== 3);
    }

    private function resetOffset(): void
    {
        $this->storeOffset(1);
    }
}