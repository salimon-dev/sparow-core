<?php

namespace Tests\Unit;

use Tests\TestCase;

class ProfileTest extends TestCase
{
    public function test_get_profile_successfull()
    {
        $response = $this->json("POST", "/api/login/plain", [
            "username" => "blue_rabbit",
            "password" => "blue_rabbit_password",
            "agent" => "unit test",
        ]);
        $response->assertStatus(200);

        $body = json_decode($response->getContent());
        $access_token = $body->user->access_token;
        $this->assertIsString($access_token);

        $response = $this->json("GET", "/api/profile", [], ["authorization" => "Bearer $access_token"]);
        $response->assertStatus(200);
        $response->assertJson([
            "user" => [
                "username" => "blue_rabbit",
            ]
        ]);
    }
    public function test_update_profile_successfull()
    {
        $response = $this->json("POST", "/api/login/plain", [
            "username" => "blue_rabbit",
            "password" => "blue_rabbit_password",
            "agent" => "unit test",
        ]);
        $response->assertStatus(200);

        $body = json_decode($response->getContent());
        $access_token = $body->user->access_token;
        $this->assertIsString($access_token);

        $response = $this->json("POST", "/api/profile", [
            "first_name" => "blue"
        ], ["authorization" => "Bearer $access_token"]);
        $response->assertStatus(200);
        $response->assertJson([
            "user" => [
                "username" => "blue_rabbit",
            ]
        ]);
    }
}
