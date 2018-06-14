<?php

namespace App\Http\Controllers\OAuth;

use App\Http\Controllers\OAuth\Contracts\Sociable;
use App\Http\Controllers\OAuth\Foundation\FirstOrSaveSocialUser;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class Facebook extends Controller implements Sociable
{
    use FirstOrSaveSocialUser;

    protected $driver = 'facebook';

    public function redirectToProvider()
    {
        return Socialite::driver($this->driver)->redirect();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver($this->driver)->user();

        $this->createOrLoginUserBy($user);

        return redirect()->to('/home');
    }
}
