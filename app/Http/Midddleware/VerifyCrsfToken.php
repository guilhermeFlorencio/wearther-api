<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Rotas que devem ser excluídas da verificação CSRF.
     *
     * @var array
     */
    protected $except = [
        'api/login',
        'api/logout',
    ];
}
