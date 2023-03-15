<?php

namespace App\Services;

class JsonFileDataAdapter
{
    private string $stringData;
    private array $arrayData = [];

    public function __construct(string $data)
    {
        $this->stringData = $data;
        $this->convertToArray();
    }

    public function getProductData(): ?array
    {
        if(empty($this->arrayData)){
            return null;
        }

        return [
            'id' => intval($this->arrayData['Product_ID']),
            'nr' => $this->arrayData['NR'],
            'name' => $this->arrayData['Name'],
            'product_url' => $this->arrayData['Product_URL'],
            'search_keywords' => $this->arrayData['Search_Keywords'],
            'description' => $this->arrayData['Description'],
            'brand' => $this->arrayData['Brand']
        ];
    }

    private function convertToArray(): void
    {
        $str = str_replace(" ", '', $this->stringData);

        if (strpos(strrev($str), ',') === 1) {
            $str = substr($str, 0, strrpos($str, ','));
        }

        $this->arrayData = json_decode($str, true) ?? [] ;
    }
}