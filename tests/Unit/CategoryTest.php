<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_post(): void
    {
        Sanctum::actingAs(
            User::find(1)//Admin
        );

        $response = $this->postJson('/api/categories', ['name' => 'Frutas']);
        $response->assertStatus(201);
        $response = $this->postJson('/api/categories', ['name' => 'Hortalizas']);
        $response->assertStatus(201);
        $response = $this->postJson('/api/categories', ['name' => 'Cítricos']);
        $response->assertStatus(201);
    }

    public function test_get(): void
    {
        Sanctum::actingAs(
            User::find(1)
        );
        $response = $this->getJson('/api/categories');
        $response->assertJson(fn(AssertableJson $json)=>$json->has('data')->etc());
        $response->assertJson(
            fn(AssertableJson $json)=>
            $json->has('data.0',fn (AssertableJson $json) =>
            $json->where('name','Frutas')->etc())->etc()
        );
    }

    public function test_get_one(): void
    {
        Sanctum::actingAs(
            User::find(1)
        );
        $response = $this->getJson('/api/categories/1?fields[categories]=id,name');
        $response->assertJson(fn(AssertableJson $json)=>
            $json->has('data',fn (AssertableJson $json) =>
                $json->where('id',1)->has('name')
            )
        );
    }

    public function test_update(): void
    {
        Sanctum::actingAs(
            User::find(1)
        );
        $response = $this->putJson('/api/categories/2', [
            'name' => 'Pescados',
        ]);

        $response = $this->getJson('/api/categories?filter[name]=Pescados');
        $response->assertJson(fn(AssertableJson $json)=>$json->has('data')->etc());
        $response->assertJson(fn(AssertableJson $json)=>
            $json->has('data.0',fn (AssertableJson $json) =>
                $json->where('name','Pescados')->etc()
            )->etc()

        );
    }

    public function test_delete(): void
    {
        Sanctum::actingAs(
            User::find(1)
        );
        $response = $this->deleteJson('/api/categories/2', [
        ]);

        $response->assertStatus(200);
    }

}
