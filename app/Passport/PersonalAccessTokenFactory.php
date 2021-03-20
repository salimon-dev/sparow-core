<?php

namespace App\Passport;

use Laravel\Passport\PersonalAccessTokenFactory as ParentClass;
use Laravel\Passport\PersonalAccessTokenResult;

class PersonalAccessTokenFactory extends ParentClass
{
    /**
     * Create a new personal access token.
     *
     * @param  mixed  $userId
     * @param  string  $name
     * @param  array  $scopes
     * @return \Laravel\Passport\PersonalAccessTokenResult
     */
    public function customMake($userId, $name, array $scopes = [], $application_id, $agent)
    {
        $response = $this->dispatchRequestToAuthorizationServer(
            $this->createRequest($this->clients->personalAccessClient(), $userId, $scopes)
        );
        $token = tap($this->findAccessToken($response), function ($token) use ($userId, $name, $application_id, $agent) {
            $this->tokens->save($token->forceFill([
                'user_id' => $userId,
                'name' => $name,
                'application_id' => $application_id,
                'agent' => $agent,
            ]));
        });
        return new PersonalAccessTokenResult(
            $response['access_token'],
            $token
        );
    }
}
