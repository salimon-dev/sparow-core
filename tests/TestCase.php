<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function login($username, $password)
    {
        $response = $this->json("POST", "/api/login/plain", [
            "username" => $username,
            "password" => $password,
            "agent" => "unit test",
        ]);
        $response->assertStatus(200);

        $body = json_decode($response->getContent());
        return $body->user->access_token;
    }
}
