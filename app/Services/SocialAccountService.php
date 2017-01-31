<?php

namespace App\Services;

use App\User;
use App\SocialAccount;
use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialAccountService
{
    public function findOrCreateUser(ProviderUser $providerUser, $provider)
    {
        $account = SocialAccount::where([
            ['provider', $provider],
            ['provider_user_id', $providerUser->getId()]
        ])->first();

        if ($account) {
            $this->updateAvatar($account->user, $providerUser->getAvatar());
            return $account->user;
        }

        $account = new SocialAccount([
            'provider' => $provider,
            'provider_user_id' => $providerUser->getId()
        ]);

        $user = User::where('email', $providerUser->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'email' => $providerUser->getEmail(),
                'name' => $providerUser->getName()
            ]);
        }

        $account->user()->associate($user);
        $account->save();

        $this->updateAvatar($user, $providerUser->getAvatar());

        return $user;
    }

    private function updateAvatar($user, $avatar)
    {
        $defaultUrl = url('imagecache/avatar/default.png');

        if ($user->hospital && $user->hospital->avatar === $defaultUrl) {
            $user->hospital->update([
                'avatar' => $avatar
            ]);
        } else if ($user->donor && $user->donor->avatar === $defaultUrl) {
            $user->donor->update([
                'avatar' => $avatar
            ]);
        }
    }
}
