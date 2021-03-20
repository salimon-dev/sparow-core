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
    public function make($userId, $name, array $scopes = [], $application_id)
    {
        $response = $this->dispatchRequestToAuthorizationServer(
            $this->createRequest($this->clients->personalAccessClient(), $userId, $scopes)
        );

        $token = tap($this->findAccessToken($response), function ($token) use ($userId, $name, $application_id) {
            $this->tokens->save($token->forceFill([
                'user_id' => $userId,
                'name' => $name,
                'application_id' => $application_id,
            ]));
        });

        return new PersonalAccessTokenResult(
            $response['access_token'],
            $token
        );
    }
}
