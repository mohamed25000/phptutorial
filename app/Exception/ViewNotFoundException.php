<?php

namespace App\Exception;

class ViewNotFoundException extends \Exception
{
    protected $message = "view not found";
}