<?php

namespace App\Exceptions;

use Exception;

class WeatherFetchException extends Exception
{
    protected $message = 'Falha ao buscar os dados meteorológicos';
    protected $code = 500;
}
