<?php

namespace App\Http\Controllers\Auth;

use App\Services\FCMTokenService;
use App\Services\ActivationService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers {
        logout as traitLogout;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    protected $activationService;

    protected $fcmTokenService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ActivationService $activationService, FCMTokenService $fcmTokenService)
    {
        $this->middleware('guest', ['except' => 'logout']);

        $this->activationService = $activationService;

        $this->fcmTokenService = $fcmTokenService;
    }

    protected function authenticated(Request $request, $user)
    {
        if (!$user->activated) {
            $this->activationService->sendActivationMail($user);
            auth()->logout();
            return back()->with('warning', 'You need to confirm your account. We have sent you an activation code, please check your email.');
        }

        $this->fcmTokenService->registerToken($request->fcm_token, $user);
        $request->session()->put('fcm-token', $request->fcm_token);

        return redirect()->intended($this->redirectPath());
    }

    public function logout(Request $request)
    {
        $fcmToken = $request->session()->get('fcm-token');
        $this->fcmTokenService->revokeToken($fcmToken, $request->user());

        return $this->traitLogout($request);
    }
}
