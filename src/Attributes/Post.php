<?php

namespace App\Attributes;

#[\Attribute(\Attribute::TARGET_METHOD)]
class Post extends Route
{
    public function __construct(string $routePath)
    {
        parent::__construct($routePath, 'post');
    }
}