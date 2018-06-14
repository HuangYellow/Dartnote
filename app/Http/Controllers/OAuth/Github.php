<?php

namespace App\Http\Controllers\OAuth;

use App\Http\Controllers\OAuth\Contracts\Sociable;
use App\Http\Controllers\Controller;
use App\Http\Controllers\OAuth\Foundation\FirstOrSaveSocialUser;
use Laravel\Socialite\Facades\Socialite;

class Github extends Controller implements Sociable
{
    use FirstOrSaveSocialUser;

    protected $driver = 'github';

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
