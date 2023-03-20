<?php

namespace App\Exceptions;

use Psr\Container\NotFoundExceptionInterface;

class ClassNotFoundException extends \Exception implements NotFoundExceptionInterface
{
    protected $message = 'Class Not Found';
    protected $code = 404;
}