<?php

namespace Tests\Unit;

use Tests\TestCase;

class ApplicationsTest extends TestCase
{
    public function test_get_application_successful_0()
    {
        $access_token = $this->login("blue_rabbit", "blue_rabbit_password");
        $response = $this->json("GET", "/api/applications", [], ["authorization" => "Bearer $access_token"]);
        $response->assertStatus(200);
        $response->assertJson(["meta" => ["total" => 0]]);
    }
    public function test_create_application_successful_0()
    {
        $access_token = $this->login("blue_rabbit", "blue_rabbit_password");

        // create application
        $response = $this->json("POST", "/api/applications", [
            "title" => "some title",
            "description" => "some description",
        ], ["authorization" => "Bearer $access_token"]);
        $response->assertStatus(201);
        // check applications list
        $response = $this->json("GET", "/api/applications", [], ["authorization" => "Bearer $access_token"]);
        $response->assertStatus(200);
        $response->assertJson(["meta" => ["total" => 1]]);
    }
    public function test_edit_application_successful_0()
    {
        $access_token = $this->login("blue_rabbit", "blue_rabbit_password");
        // check applications list
        $response = $this->json("GET", "/api/applications", [], ["authorization" => "Bearer $access_token"]);
        $response->assertStatus(200);
        $response->assertJson(["meta" => ["total" => 1]]);

        $application_id = json_decode($response->getContent())->data[0]->id;

        // create application
        $response = $this->json("POST", "/api/applications/" . $application_id, [
            "title" => "some title (edited)",
        ], ["authorization" => "Bearer $access_token"]);
        $response->assertStatus(200);
        $response->assertJson(["application" => ["title" => "some title (edited)"]]);
    }

    public function test_remove_application_successful_0()
    {
        $access_token = $this->login("blue_rabbit", "blue_rabbit_password");

        // check applications list
        $response = $this->json("GET", "/api/applications", [], ["authorization" => "Bearer $access_token"]);
        $response->assertStatus(200);
        $response->assertJson(["meta" => ["total" => 1]]);

        $application_id = json_decode($response->getContent())->data[0]->id;

        // create application
        $response = $this->json("DELETE", "/api/applications/" . $application_id, [], ["authorization" => "Bearer $access_token"]);
        $response->assertStatus(200);

        // check applications list
        $response = $this->json("GET", "/api/applications", [], ["authorization" => "Bearer $access_token"]);
        $response->assertStatus(200);
        $response->assertJson(["meta" => ["total" => 0]]);

        // create application (for next tests)
        $response = $this->json("POST", "/api/applications", [
            "title" => "some title",
            "description" => "some description",
        ], ["authorization" => "Bearer $access_token"]);
        $response->assertStatus(201);
    }
}
