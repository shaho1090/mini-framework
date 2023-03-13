<?php

namespace App\Attributes;

#[\Attribute(\Attribute::TARGET_METHOD)]
class Route
{
    public function __construct(
        public string $routePath,
        public string $method = 'get'
    )
    {}
}