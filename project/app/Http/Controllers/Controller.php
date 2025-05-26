<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;



    public function empty()
    {
       return response()->json([ 'data' => [] ]);
    }

    public function success($mensagem, $corpo, $codigo)
    {
        return  response()->json([
            'success' => true,
            'msg' => $mensagem,
            'body' => $corpo
        ],$codigo);
    }
    public function error($error, $codigo)
    {
        return  response()->json([
            'success' => false,
            'error' => $error
        ], $codigo);
    }
    public function errorService($error, $codigo)
    {
        return  response()->json($error, $codigo);
    }

    /* HTTP CODES USED
        • 200: Request successful,
        • 201: Request successful and resource created,
        • 204: Request successful and resource deleted,
        • 400: Invalid request syntax,
        • 401: Unauthorized, the client must authenticate first,
        • 403: Forbidden, the client is known but the resource is forbidden for this client,
        • 404: Requested resource not found,
        • 411: Invalid validation,
        • 500: Internal server error, contact support
        
    */
}
