<?php

namespace App\Http\Controllers\OAuth\Contracts;


interface Sociable
{
    public function redirectToProvider();

    public function handleProviderCallback();
}