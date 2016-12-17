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
                'name' => $providerName->getName()
            ]);
        }

        $account->user()->associate($user);
        $account->save();

        return $user;
    }
}