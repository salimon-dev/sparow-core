<?php

namespace Tests\Unit;

use App\Models\Application;
use App\Models\ValidDomain;
use Tests\TestCase;

class ValidDomainsTest extends TestCase
{
    public function test_get_valid_domins_successful_0()
    {
        $access_token = $this->login("blue_rabbit", "blue_rabbit_password");
        $response = $this->json("GET", "/api/valid-domains", [], ["authorization" => "Bearer $access_token"]);
        $response->assertStatus(200);
        $response->assertJson(["meta" => ["total" => 0]]);
    }
    // public function test_create_valid_domin_successful_0()
    // {
    //     $access_token = $this->login("blue_rabbit", "blue_rabbit_password");
    //     // get the application instance from database
    //     $application = Application::first();
    //     // create valid_domins
    //     $response = $this->json("POST", "/api/valid-domains", [
    //         "url" => "http://localhost:3000/auth-callback",
    //         "application_id" => $application->id,
    //     ], ["authorization" => "Bearer $access_token"]);
    //     $response->assertStatus(201);
    //     // check valid-domains list
    //     $response = $this->json("GET", "/api/valid-domains", [], ["authorization" => "Bearer $access_token"]);
    //     $response->assertStatus(200);
    //     $response->assertJson(["meta" => ["total" => 1]]);
    // }
    // public function test_edit_valid_domins_successful_0()
    // {
    //     $access_token = $this->login("blue_rabbit", "blue_rabbit_password");
    //     // get the application instance from database
    //     $valid_domin = ValidDomain::first();
    //     // edit valid_domins
    //     $response = $this->json("POST", "/api/valid-domains/" . $valid_domin->id, [
    //         "url" => "http://localhost:5000/auth/callback",
    //     ], ["authorization" => "Bearer $access_token"]);
    //     $response->assertStatus(200);
    //     // check the changed prop
    //     $response->assertJson(["valid_domin" => ["url" => "http://localhost:5000/auth/callback"]]);
    // }

    // public function test_remove_valid_domins_successful_0()
    // {
    //     $access_token = $this->login("blue_rabbit", "blue_rabbit_password");
    //     // check valid-domains list
    //     $response = $this->json("GET", "/api/valid-domains", [], ["authorization" => "Bearer $access_token"]);
    //     $response->assertStatus(200);
    //     $response->assertJson(["meta" => ["total" => 1]]);
    //     $valid_domins_id = json_decode($response->getContent())->data[0]->id;
    //     // create valid_domins
    //     $response = $this->json("DELETE", "/api/valid-domains/" . $valid_domins_id, [], ["authorization" => "Bearer $access_token"]);
    //     $response->assertStatus(200);
    //     // check valid-domains list
    //     $response = $this->json("GET", "/api/valid-domains/", [], ["authorization" => "Bearer $access_token"]);
    //     $response->assertStatus(200);
    //     $response->assertJson(["meta" => ["total" => 0]]);
    //     // get the application instance from database
    //     $application = Application::first();
    //     // create valid_domins (for next tests)
    //     $response = $this->json("POST", "/api/valid-domains", [
    //         "url" => "http://localhost:3000/auth-callback",
    //         "application_id" => $application->id,
    //     ], ["authorization" => "Bearer $access_token"]);
    //     $response->assertStatus(201);
    // }
}
