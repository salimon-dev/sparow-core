<?php

namespace Tests\Unit;

use Tests\TestCase;

class AuthTest extends TestCase
{
    public function test_register_fails_for_wrong_verb()
    {
        $response = $this->json("GET", "/api/register/plain");
        $response->assertStatus(405);
    }
    public function test_register_fails_for_no_parameter()
    {
        $response = $this->json("POST", "/api/register/plain");
        $response->assertStatus(422);
    }
    public function test_register_fails_for_duplicated_username()
    {
        $response = $this->json("POST", "/api/register/plain", [
            "username" => "blue_rabbit",
            "password" => "some_password",
            "email" => "blue@rabbit.com"

        ]);
        $response->assertStatus(422);
    }
    public function test_register_fails_for_duplicated_email()
    {
        $response = $this->json("POST", "/api/register/plain", [
            "username" => "some_other_user",
            "password" => "some_password",
            "email" => "sparow@salimon.ir",
        ]);
        $response->assertStatus(422);
    }
    public function test_register_fails_for_duplicated_phone()
    {
        $response = $this->json("POST", "/api/register/plain", [
            "username" => "some_other_user",
            "password" => "some_password",
            "email" => "blue-rabbit@salimon.ir",
            "phone" => "09216720496"
        ]);
        $response->assertStatus(422);
    }
    public function test_register_fails_for_short_password()
    {
        $response = $this->json("POST", "/api/register/plain", [
            "username" => "some_other_user",
            "password" => "some",
            "email" => "blue-rabbit@salimon.ir",
            "phone" => "09111111111"
        ]);
        $response->assertStatus(422);
    }
    public function test_success_register()
    {
        $response = $this->json("POST", "/api/register/plain", [
            "username" => "test_user",
            "password" => "some_password",
            "email" => "blue-rabbit@salimon.ir",
            "phone" => "09111111111",
            "agent" => "php unit test"
        ]);
        $response->assertStatus(201);
    }
    public function test_login_failed_wrong_verb()
    {
        $response = $this->json("GET", "/api/login/plain");
        $response->assertStatus(405);
    }
    public function test_login_failed_for_no_parameters()
    {
        $response = $this->json("POST", "/api/login/plain");
        $response->assertStatus(422);
    }
    public function test_login_failed_for_agent()
    {
        $response = $this->json("POST", "/api/login/plain", [
            "username" => "username",
            "password" => "password",
        ]);
        $response->assertStatus(422);
    }
    public function test_login_failed_for_wrong_inputs()
    {
        $response = $this->json("POST", "/api/login/plain", [
            "username" => "username",
            "password" => "password",
            "agent" => "php unit test",
        ]);
        $response->assertStatus(401);
    }
    public function test_login_success()
    {
        $response = $this->json("POST", "/api/login/plain", [
            "username" => "test_user",
            "password" => "some_password",
            "agent" => "php unit test",
        ]);
        $response->assertStatus(200);
        $body = json_decode($response->getContent());
        $access_token = $body->user->access_token;

        $response = $this->json("POST", "/api/logout", [], ["authorization" => "Bearer $access_token"]);
        $response->assertStatus(200);
    }
}
