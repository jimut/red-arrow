<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Socialite;
use App\Services\FCMTokenService;
use App\Services\SocialAccountService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SocialAuthController extends Controller
{
    protected $fcmTokenService;

    public function __construct(FCMTokenService $fcmTokenService)
    {
        $this->fcmTokenService = $fcmTokenService;
    }

    public function redirect(Request $request, $provider)
    {
        session()->put('fcm-token', $request->fcm_token);

        return Socialite::driver($provider)->redirect();
    }

    public function callback(SocialAccountService $service, $provider)
    {
        $providerUser = Socialite::driver($provider)->user();

        $user = $service->findOrCreateUser($providerUser, $provider);

        Auth::login($user);

        $this->fcmTokenService->registerToken(session('fcm-token'), $user);

        return redirect('/');
    }
}
