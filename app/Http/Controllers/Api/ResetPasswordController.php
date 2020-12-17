<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Request;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected function sendResetResponse(Request $request, $response)
    {
        return response(['message' => $response]);
    }

    protected function sendResetFailedResponse(Request $request, $response)
    {
        return response(['message' => $response], 422);
    }

}
