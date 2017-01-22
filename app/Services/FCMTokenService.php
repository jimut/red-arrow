<?php

namespace App\Services;

use App\Repositories\FCMTokenRepository;

class FCMTokenService
{
    protected $fcmTokenRepo;

    public function __construct(FCMTokenRepository $fcmTokenRepo)
    {
        $this->fcmTokenRepo = $fcmTokenRepo;
    }

    public function registerToken($token, $user = null)
    {
        if (!$user) {
            return $this->fcmTokenRepo->storeIndependentToken($token);
        }

        $fcmToken = $this->fcmTokenRepo->getByToken($token);

        if (!$fcmToken) {
            return $this->fcmTokenRepo->storeDependentToken($token, $user);
        }

        if ($fcmToken->user_id !== $user->id) {
            return $this->fcmTokenRepo->updateByToken($token, $user);
        }

        return true;
    }

    public function revokeToken($token, $user = null)
    {
        $fcmToken = $this->fcmTokenRepo->getByToken($token);

        if (!$fcmToken) return;

        if (!$user && !$fcmToken->user_id) {
            $this->fcmTokenRepo->deleteToken($token);
            return true;
        }

        if ($fcmToken->user_id !== $user->id) {
            abort(403);
        }

        $this->fcmTokenRepo->deleteToken($token);
        return true;
    }
}
