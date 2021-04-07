<?php

namespace Tests\Unit;

use App\Models\Application;
use App\Models\RedirectUrl;
use Tests\TestCase;

class RedirectUrlsTest extends TestCase
{
    public function test_get_redirect_urls_successful_0()
    {
        $access_token = $this->login("blue_rabbit", "blue_rabbit_password");
        $response = $this->json("GET", "/api/redirect-urls", [], ["authorization" => "Bearer $access_token"]);
        $response->assertStatus(200);
        $response->assertJson(["meta" => ["total" => 0]]);
    }
    public function test_create_redirect_url_successful_0()
    {
        $access_token = $this->login("blue_rabbit", "blue_rabbit_password");
        // get the application instance from database
        $application = Application::first();
        // create redirect_urls
        $response = $this->json("POST", "/api/redirect-urls", [
            "url" => "http://localhost:3000/auth-callback",
            "application_id" => $application->id,
        ], ["authorization" => "Bearer $access_token"]);
        $response->assertStatus(201);
        // check redirect-urls list
        $response = $this->json("GET", "/api/redirect-urls", [], ["authorization" => "Bearer $access_token"]);
        $response->assertStatus(200);
        $response->assertJson(["meta" => ["total" => 1]]);
    }
    public function test_edit_redirect_urls_successful_0()
    {
        $access_token = $this->login("blue_rabbit", "blue_rabbit_password");
        // get the application instance from database
        $redirect_url = RedirectUrl::first();
        // edit redirect_urls
        $response = $this->json("POST", "/api/redirect-urls/" . $redirect_url->id, [
            "url" => "http://localhost:5000/auth/callback",
        ], ["authorization" => "Bearer $access_token"]);
        $response->assertStatus(200);
        // check the changed prop
        $response->assertJson(["redirect_url" => ["url" => "http://localhost:5000/auth/callback"]]);
    }

    public function test_remove_redirect_urls_successful_0()
    {
        $access_token = $this->login("blue_rabbit", "blue_rabbit_password");
        // check redirect-urls list
        $response = $this->json("GET", "/api/redirect-urls", [], ["authorization" => "Bearer $access_token"]);
        $response->assertStatus(200);
        $response->assertJson(["meta" => ["total" => 1]]);
        $redirect_urls_id = json_decode($response->getContent())->data[0]->id;
        // create redirect_urls
        $response = $this->json("DELETE", "/api/redirect-urls/" . $redirect_urls_id, [], ["authorization" => "Bearer $access_token"]);
        $response->assertStatus(200);
        // check redirect-urls list
        $response = $this->json("GET", "/api/redirect-urls/", [], ["authorization" => "Bearer $access_token"]);
        $response->assertStatus(200);
        $response->assertJson(["meta" => ["total" => 0]]);
        // get the application instance from database
        $application = Application::first();
        // create redirect_urls (for next tests)
        $response = $this->json("POST", "/api/redirect-urls", [
            "url" => "http://localhost:3000/auth-callback",
            "application_id" => $application->id,
        ], ["authorization" => "Bearer $access_token"]);
        $response->assertStatus(201);
    }
}
