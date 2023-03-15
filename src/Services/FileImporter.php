<?php

namespace App\Services;

use App\Model\Product;

class FileImporter
{
    private JsonFileDataAdapter $jsonFileAdapter;

    public function __construct(string $data)
    {
        $this->jsonFileAdapter = new JsonFileDataAdapter($data);
    }

    public function import(): void
    {
        $this->importProductData();
    }

    private function importProductData(): void
    {
        $data = $this->jsonFileAdapter->getProductData();

        if(!is_null($data)){
            $product = new Product();
            $product->insert($data);
        }
    }
}