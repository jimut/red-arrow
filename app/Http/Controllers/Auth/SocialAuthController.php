<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Socialite;
use App\Services\SocialAccountService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SocialAuthController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback(SocialAccountService $service, $provider)
    {
        $providerUser = Socialite::driver($provider)->user();
        
        $user = $service->findOrCreateUser($providerUser, $provider);

        Auth::login($user);

        return redirect('/');
    }
}
