<?php

namespace App\Passport;

use Illuminate\Container\Container;

trait CustomizedCreateToken
{
    /**
     * Create a new personal access token for the user.
     *
     * @param  string  $name
     * @param  array  $scopes
     * @return \Laravel\Passport\PersonalAccessTokenResult
     */
    public function customCreateToken($name, array $scopes = [], $application_id, $agent, $ip)
    {
        return Container::getInstance()->make(PersonalAccessTokenFactory::class)->customMake(
            $this->getKey(),
            $name,
            $scopes,
            $application_id,
            $agent,
            $ip,
        );
    }
}
