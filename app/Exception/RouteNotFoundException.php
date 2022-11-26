<?php

namespace App\Exception;

class RouteNotFoundException extends \Exception
{
    protected $message = "route not found";
}