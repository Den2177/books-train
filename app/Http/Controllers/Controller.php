<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function vError($v)
    {
        return response()->json(
            [
                'error' => [
                    'code' => 422,
                    'message' => 'Validation error',
                    'errors' => $v->errors(),
                ]
            ], 422
        );
    }

    public function error($message = 'Login failed', $code = 401)
    {
        return response()->json(
            [
                'error' => [
                    'code' => $code,
                    'message' =>$message
                ]
            ], $code
        );
    }
}
