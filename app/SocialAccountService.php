<?php

namespace App;

use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialAccountService {

    public function findOrCreate(ProviderUser $providerUser, $provider) {

        $account = SocialAccount::where('provider_id', $providerUser->getId())->where('provider_name', $provider)->first();

        if ($account) {
            return $account->user;
        } else {
            $user = User::where('email', $providerUser->getEmail())->first();
            if (!$user) {
                $user = User::create([
                    'email' => $providerUser->getEmail(),
                    'name' => $providerUser->getName()
                ]);
            }
            $user->accounts()->create([
                'provider_name' => $provider,
                'provider_id' => $providerUser->getId()
            ]);
            return $user;

        }

    }
}

