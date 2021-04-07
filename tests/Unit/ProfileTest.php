<?php

namespace Tests\Unit;

use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    public function test_get_profile_successful()
    {
        $access_token = $this->login("blue_rabbit", "blue_rabbit_password");

        $response = $this->json("GET", "/api/profile", [], ["authorization" => "Bearer $access_token"]);
        $response->assertStatus(200);
        $response->assertJson([
            "user" => [
                "username" => "blue_rabbit",
            ]
        ]);
    }
    public function test_update_profile_successful_0()
    {
        $access_token = $this->login("blue_rabbit", "blue_rabbit_password");

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
    public function test_update_profile_successful_1()
    {
        $access_token = $this->login("blue_rabbit", "blue_rabbit_password");

        $response = $this->json("POST", "/api/profile", [
            "first_name" => "blue",
            "avatar" => UploadedFile::fake()->image("avatar.jpg", 128, 128),
        ], ["authorization" => "Bearer $access_token"]);
        $response->assertStatus(200);
        $response->assertJson([
            "user" => [
                "username" => "blue_rabbit",
            ]
        ]);
    }
}
