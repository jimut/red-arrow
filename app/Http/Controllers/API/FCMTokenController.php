<?php

namespace App\Http\Controllers\API;

use App\Services\FCMTokenService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FCMTokenController extends Controller
{
    protected $fcmTokenService;

    public function __construct(FCMTokenService $fcmTokenService)
    {
        $this->middleware('auth:api');

        $this->fcmTokenService = $fcmTokenService;
    }

    public function register(Request $request, $token)
    {
        $result = $this->fcmTokenService->registerToken($token, $request->user());

        return response()->json([
            'success' => $result
        ]);
    }

    public function revoke(Request $request, $token) 
    {
        $result = $this->fcmTokenService->revokeToken($token, $request->user());

        return response()->json([
            'success' => $result
        ]);
    }
}
