<?php

namespace App\Exceptions;

class FileNotFoundException extends RouteNotFoundException
{
    protected $message = 'File Not Found!';
}