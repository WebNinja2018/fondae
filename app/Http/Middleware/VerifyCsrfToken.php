<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
	protected function tokensMatch($request)
    {
        return $request->session()->token() == $request->header('x-csrf-token');
    }
	
    protected $except = [
        //
    ];
}
