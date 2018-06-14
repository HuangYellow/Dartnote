<?php

namespace App\Http\Controllers\OAuth\Foundation;

use App\Exceptions\PropertyNotFoundException;
use App\User;
use Auth;
use Laravel\Socialite\Two\User as SocialUser;

trait FirstOrSaveSocialUser
{
    /**
     * @param SocialUser $user
     * @return User|false
     * @throws \Throwable
     */
    public function createOrLoginUserBy(SocialUser $user)
    {
        throw_if(! property_exists($this, 'driver'), PropertyNotFoundException::class, 'driver');

        $concrete = User::firstOrNew([
            'email' => $user->email
        ]);

        $concrete->fill([
            "{$this->driver}_id" => $user->id,
            'nickname' => $concrete->exists ? $concrete->nickname : $this->driver . '_' . str_random(10),
            'name' => $concrete->exists ? $concrete->name : $user->name,
            'password' => $concrete->exists ? $concrete->password : bcrypt(str_random(10)),
        ])->save();

        return Auth::loginUsingId($concrete->id);
    }
}