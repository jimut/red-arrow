<?php

namespace App\Http\Controllers\Auth;

use App\Services\ActivationService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RedirectsUsers;

class ActivationController extends Controller
{
    use RedirectsUsers;

    protected $redirectTo = '/';

    protected $activationService;

    public function __construct(ActivationService $activationService)
    {
        $this->middleware('guest');

        $this->activationService = $activationService;
    }

    public function activate($token)
    {
        if ($user = $this->activationService->activateUser($token)) {
            auth()->login($user);
            return redirect($this->redirectPath());
        }

        abort(404);
    }
}
