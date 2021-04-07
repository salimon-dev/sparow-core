<?php

namespace Tests\Unit;

use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class SessionsTest extends TestCase
{
    public function test_get_sessions_successful()
    {
        $access_token = $this->login("blue_rabbit", "blue_rabbit_password");
        $response = $this->json("GET", "/api/sessions", [], ["authorization" => "Bearer $access_token"]);
        $response->assertStatus(200);
    }

    public function test_remove_all_sessions_but_me_successful()
    {
        $access_token = $this->login("blue_rabbit", "blue_rabbit_password");
        // get sessions
        $response = $this->json("GET", "/api/sessions", [], ["authorization" => "Bearer $access_token"]);
        $response->assertStatus(200);
        $response->assertJSON([
            "meta" => [
                "total" => 5
            ]
        ]);
        // remove all sessions but me
        $response = $this->json("delete", "/api/sessions/all-but-me", [], ["authorization" => "Bearer $access_token"]);
        $response->assertStatus(200);
        // get sessions
        $response = $this->json("GET", "/api/sessions", [], ["authorization" => "Bearer $access_token"]);
        $response->assertStatus(200);
        $response->assertJSON([
            "meta" => [
                "total" => 1
            ]
        ]);
    }
    public function test_remove_single_session()
    {
        $access_token = $this->login("blue_rabbit", "blue_rabbit_password");
        // get sessions
        $response = $this->json("GET", "/api/sessions", ["others"], ["authorization" => "Bearer $access_token"]);
        $response->assertStatus(200);
        $response->assertJSON([
            "meta" => [
                "total" => 2
            ]
        ]);
        // remove all sessions
        foreach (json_decode($response->getContent())->data as $session) {
            if (!$session->current) {
                $response = $this->json("DELETE", "/api/sessions/" . $session->id, [], ["authorization" => "Bearer $access_token"]);
                $response->assertStatus(200);
            }
        }
        // get sessions
        $response = $this->json("GET", "/api/sessions", [], ["authorization" => "Bearer $access_token"]);
    }
}
