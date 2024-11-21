<?php

namespace App\Exceptions;

use Exception;

class CityNotFoundException extends Exception
{
    protected $message = 'Cidade não encontrada';
    protected $code = 404;
}
