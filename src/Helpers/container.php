<?php

if (!function_exists('container')) {
    function container(): \App\Container
    {
       return new \App\Container();
    }
}