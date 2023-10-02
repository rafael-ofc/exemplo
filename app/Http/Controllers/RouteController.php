<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function ping()
    {
        return [
            'pong' => true
        ];
    }

    public function unauthorized()
    {
        return response()->json([
            'error' => 'Não autorizado'
        ], 401);
    }
}
